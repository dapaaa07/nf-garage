<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oli;
use App\Models\InternalModel;
use App\Models\LainnyaModel;
use App\Models\RemModel;
use App\Models\MessageModel;

class HomeController extends Controller
{
    public function index()
    {
        $oli = Oli::all();
        $rem = RemModel::all();
        $internal = InternalModel::all();
        $lainnya = LainnyaModel::all();

        $oli1 = Oli::sum('stok');
        $rem1 = RemModel::sum('stok');
        $internal1 = InternalModel::sum('stok');
        $lainnya1 = LainnyaModel::sum('stok');

        // Gabungkan semua koleksi menggunakan concat()
        $data = $oli->concat($rem)->concat($internal)->concat($lainnya);
        $TotalStok = $oli1 + $rem1 + $internal1 + $lainnya1;

        return view('welcome', compact('data', 'TotalStok'));
    }

    public function message(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'message' => 'required|string', // Ubah text menjadi string
        ]);

        MessageModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
