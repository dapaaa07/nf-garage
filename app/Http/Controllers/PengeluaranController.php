<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\PengeluaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PengeluaranController extends Controller
{
    /**
     * Menampilkan daftar semua data pengeluaran.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $pengeluaran = PengeluaranModel::latest()->get();
        // Pastikan nama view ini sesuai dengan struktur folder Anda
        return view('admin.pengeluaran.index', compact('pengeluaran'));
    }

    /**
     * Menampilkan formulir untuk membuat data pengeluaran baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Pastikan nama view ini sesuai dengan struktur folder Anda
        return view('admin.pengeluaran.add');
    }

    /**
     * Menyimpan data pengeluaran baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang'      => 'required|string|max:255',
            'kuantitas'        => 'required|integer|min:1',
            'harga_per_barang' => 'required|numeric|min:0',
        ]);

        $totalHarga = $validatedData['kuantitas'] * $validatedData['harga_per_barang'];

        PengeluaranModel::create([
            'nama_barang'      => $validatedData['nama_barang'],
            'kuantitas'        => $validatedData['kuantitas'],
            'harga_per_barang' => $validatedData['harga_per_barang'],
            'total_harga'      => $totalHarga,
        ]);

        return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil disimpan!');
    }

    /**
     * PERBAIKAN: Menampilkan formulir untuk mengedit data pengeluaran.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\View\View
     */
    public function edit(PengeluaranModel $pengeluaran)
    {
        // Laravel secara otomatis akan mencari data Pengeluaran berdasarkan ID dari URL.
        // Kemudian data tersebut dikirim ke view 'update'.
        return view('admin.pengeluaran.update', compact('pengeluaran'));
    }

    /**
     * Memperbarui data pengeluaran di dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PengeluaranModel $pengeluaran)
    {
        $validatedData = $request->validate([
            'nama_barang'      => 'required|string|max:255',
            'kuantitas'        => 'required|integer|min:1',
            'harga_per_barang' => 'required|numeric|min:0',
        ]);

        $totalHarga = $validatedData['kuantitas'] * $validatedData['harga_per_barang'];

        $pengeluaran->update([
            'nama_barang'      => $validatedData['nama_barang'],
            'kuantitas'        => $validatedData['kuantitas'],
            'harga_per_barang' => $validatedData['harga_per_barang'],
            'total_harga'      => $totalHarga,
        ]);

        return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui!');
    }

    /**
     * Menghapus data pengeluaran dari database.
     *
     * @param  \App\Models\Pengeluaran  $pengeluaran
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(PengeluaranModel $pengeluaran)
    {
        $pengeluaran->delete();
        return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus!');
    }
}
