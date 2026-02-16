<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oli;
use Illuminate\Support\Str;

class OliController extends Controller
{
    public function index()
    {
        $olis = Oli::All();
        return view('stok/oli', compact('olis'));
    }

    public function create()
    {
        return view('stok/oli_create');
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

        $oli = Oli::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'foto' => $fileName ?? null,
        ]);

        // dd($oli); // Cek apakah data berhasil dibuat sebelum redirect

        return redirect()->route('oli')->with('success', 'Product added successfully!');
    }


    public function edit($id)
    {
        $oli = Oli::findOrFail($id);
        return view('stok/oli_edit', compact('oli'));
    }

    public function update(Request $request, $id)
    {
        $oli = Oli::findOrFail($id);

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
            if ($oli->foto && file_exists(public_path('assets/foto/' . $oli->foto))) {
                unlink(public_path('assets/foto/' . $oli->foto));
            }

            // Ambil file foto yang baru
            $file = $request->file('foto');

            // Generate nama file random dan simpan dengan ekstensi yang sama
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Pindahkan file ke folder public/assets/foto
            $file->move(public_path('assets/foto'), $fileName);

            // Update nama file foto di database
            $oli->foto = $fileName;
        }

        // Update data produk lainnya
        $oli->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect()->route('oli')->with('success', 'Oli berhasil diperbarui');
    }


    public function destroy($id)
    {
        $oli = Oli::findOrFail($id);

        // Cek apakah ada foto yang terkait dengan produk
        if ($oli->foto && file_exists(public_path('assets/foto/' . $oli->foto))) {
            // Hapus file foto
            unlink(public_path('assets/foto/' . $oli->foto));
        }

        // Hapus data produk dari database
        $oli->delete();

        return redirect()->route('oli')->with('success', 'Oli berhasil dihapus');
    }
}
