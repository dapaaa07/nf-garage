<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman form registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Menangani proses registrasi user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_verified' => false,
            'verification_code' => rand(100000, 999999),
        ]);

        // Mengirim email dengan data nama dan kode secara langsung
        Mail::to($user->email)->send(new VerificationCodeMail($user->name, $user->verification_code));

        return redirect()->route('verification.form')->with('email', $user->email);
    }

    /**
     * Menampilkan halaman form untuk memasukkan kode verifikasi.
     */
    public function showVerificationForm()
    {
        if (!session('email')) {
            return redirect()->route('login');
        }

        return view('auth.verify');
    }

    /**
     * Memproses kode verifikasi yang diinput user.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric|digits:6',
        ]);

        $user = User::where('verification_code', $request->code)
            ->where('is_verified', false)
            ->first();

        if (!$user) {
            return back()->withErrors(['code' => 'Kode verifikasi yang Anda masukkan salah.'])->with('email', session('email'));
        }

        $user->is_verified = true;
        $user->verification_code = null;
        $user->save();

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil diverifikasi! Selamat datang!');
    }

    /**
     * Mengirim ulang kode verifikasi.
     */
    public function resendCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->is_verified) {
            $user->verification_code = rand(100000, 999999);
            $user->save();

            // Mengirim email dengan data nama dan kode secara langsung
            Mail::to($user->email)->send(new VerificationCodeMail($user->name, $user->verification_code));

            // Mengembalikan ke halaman sebelumnya dengan pesan sukses dan session email
            return back()->with('success', 'Kode verifikasi baru telah dikirim ulang.')->with('email', $user->email);
        }

        return back()->withErrors(['email' => 'Gagal mengirim ulang kode. Mungkin akun sudah terverifikasi.'])->with('email', $request->email);
    }

    /**
     * Menampilkan halaman form login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menangani proses login user dengan pengecekan verifikasi.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->withInput();
        }

        if (!$user->is_verified) {
            $user->verification_code = rand(100000, 999999);
            $user->save();

            // Mengirim email dengan data nama dan kode secara langsung
            Mail::to($user->email)->send(new VerificationCodeMail($user->name, $user->verification_code));

            return redirect()->route('verification.form')
                ->with('email', $user->email)
                ->withErrors(['code' => 'Akun Anda belum terverifikasi. Kami telah mengirim ulang kode ke email Anda.']);
        }
        // Bagian akhir dari metode login() Anda
        Auth::login($user, $request->remember);
        $request->session()->regenerate();

        // LOGIKA PENGALIHAN BERDASARKAN LEVEL
        if ($user->level == 'Admin') {
            // Jika level adalah Admin, arahkan ke dashboard admin
            return redirect()->intended('/dashboard')->with('success', 'Login berhasil! Selamat datang, Admin!');
        } else {
            // Jika level adalah User (atau level lainnya), arahkan ke homepage
            return redirect()->intended('/')->with('success', 'Login berhasil!');
        }
    }

    /**
     * Menangani proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
