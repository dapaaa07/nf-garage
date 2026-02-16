<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LainnyaModel;
use Illuminate\Support\Str;

class LainnyaController extends Controller
{
    public function index()
    {
        $lainnya = LainnyaModel::All();
        return view('stok/lainnya', compact('lainnya'));
    }

    public function create()
    {
        return view('stok/lainnya_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/foto'), $fileName);
        }

        $lainnya = LainnyaModel::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'foto' => $fileName ?? null,
        ]);

        // dd($lainnya); // Cek apakah data berhasil dibuat sebelum redirect

        return redirect()->route('lainnya')->with('success', 'Product added successfully!');
    }


    public function edit($id)
    {
        $lainnya = LainnyaModel::findOrFail($id);
        return view('stok/lainnya_edit', compact('lainnya'));
    }

    public function update(Request $request, $id)
    {
        $lainnya = LainnyaModel::findOrFail($id);

        // Validasi input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Jika ada file foto baru yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($lainnya->foto && file_exists(public_path('assets/foto/' . $lainnya->foto))) {
                unlink(public_path('assets/foto/' . $lainnya->foto));
            }

            // Ambil file foto yang baru
            $file = $request->file('foto');

            // Generate nama file random dan simpan dengan ekstensi yang sama
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Pindahkan file ke folder public/assets/foto
            $file->move(public_path('assets/foto'), $fileName);

            // Update nama file foto di database
            $lainnya->foto = $fileName;
        }

        // Update data produk lainnya
        $lainnya->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect()->route('lainnya')->with('success', 'lainnya berhasil diperbarui');
    }


    public function destroy($id)
    {
        $lainnya = LainnyaModel::findOrFail($id);

        // Cek apakah ada foto yang terkait dengan produk
        if ($lainnya->foto && file_exists(public_path('assets/foto/' . $lainnya->foto))) {
            // Hapus file foto
            unlink(public_path('assets/foto/' . $lainnya->foto));
        }

        // Hapus data produk dari database
        $lainnya->delete();

        return redirect()->route('lainnya')->with('success', 'lainnya berhasil dihapus');
    }
}
