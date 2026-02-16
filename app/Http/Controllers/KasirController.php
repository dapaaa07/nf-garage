<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oli;
use App\Models\InternalModel;
use App\Models\LainnyaModel;
use App\Models\RemModel;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua data dan tambahkan kategori seperti sebelumnya
        $oli = Oli::all()->map(function ($item) {
            $item->kategori = 'Oli';
            return $item;
        });

        $rem = RemModel::all()->map(function ($item) {
            $item->kategori = 'Rem';
            return $item;
        });

        $internal = InternalModel::all()->map(function ($item) {
            $item->kategori = 'Internal';
            return $item;
        });

        $lainnya = LainnyaModel::all()->map(function ($item) {
            $item->kategori = 'Lainnya';
            return $item;
        });

        $data = $oli->concat($rem)->concat($internal)->concat($lainnya);
        $TotalStok = $data->sum('stok');

        // 2. Terapkan filter berdasarkan kategori dari request URL
        if ($request->has('kategori') && $request->kategori != 'Semua') {
            $data = $data->where('kategori', $request->kategori);
        }

        // 3. Terapkan filter berdasarkan pencarian dari request URL
        if ($request->has('search') && $request->search != '') {
            $searchQuery = strtolower($request->search);
            $data = $data->filter(function ($item) use ($searchQuery) {
                // cari apakah nama produk mengandung query pencarian (case-insensitive)
                return str_contains(strtolower($item->nama), $searchQuery);
            });
        }

        // 4. Kirim data yang sudah difilter ke view
        return view('admin.kasir', compact('data', 'TotalStok'));
    }
}
