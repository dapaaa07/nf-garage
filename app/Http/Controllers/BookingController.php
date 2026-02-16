<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingModel;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar booking milik user yang sedang login.
     */
    public function index()
    {
        // Ambil semua data booking milik user saat ini, urutkan dari yang terbaru
        $bookings = BookingModel::where('user_id', Auth::id())
            ->latest()
            ->paginate(10); // Gunakan paginate jika data banyak

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Menampilkan form untuk membuat booking baru.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Menyimpan data booking baru ke dalam database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'vehicle_description' => 'required|string|max:255',
        ], [
            'booking_date.required' => 'Tanggal booking wajib diisi.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh hari yang sudah lewat.',
            'vehicle_description.required' => 'Deskripsi kendaraan wajib diisi.',
        ]);

        // 2. Generate kode booking yang unik
        // Format: BK-USERID-TIMESTAMP
        $bookingCode = 'BK-' . Auth::id() . '-' . time();

        // 3. Simpan data ke database
        BookingModel::create([
            'user_id' => Auth::id(), // Ambil ID user yang sedang login
            'booking_code' => $bookingCode,
            'booking_date' => $request->booking_date,
            'vehicle_description' => $request->vehicle_description,
            'status' => 'pending', // Status default saat booking dibuat
        ]);

        // 4. Arahkan user ke halaman riwayat booking dengan pesan sukses
        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat! Mohon tunggu konfirmasi dari kami.');
    }
}
