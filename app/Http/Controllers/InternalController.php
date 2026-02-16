<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternalModel;
use Illuminate\Support\Str;

class InternalController extends Controller
{
    public function index()
    {
        $internal = InternalModel::All();
        return view('stok/internal', compact('internal'));
    }

    public function create()
    {
        return view('stok/internal_create');
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

        $internal = InternalModel::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
            'stok' => $request->stok,
            'foto' => $fileName ?? null,
        ]);

        // dd($internal); // Cek apakah data berhasil dibuat sebelum redirect

        return redirect()->route('internal')->with('success', 'Product added successfully!');
    }


    public function edit($id)
    {
        $internal = InternalModel::findOrFail($id);
        return view('stok/internal_edit', compact('internal'));
    }

    public function update(Request $request, $id)
    {
        $internal = InternalModel::findOrFail($id);

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
            if ($internal->foto && file_exists(public_path('assets/foto/' . $internal->foto))) {
                unlink(public_path('assets/foto/' . $internal->foto));
            }

            // Ambil file foto yang baru
            $file = $request->file('foto');

            // Generate nama file random dan simpan dengan ekstensi yang sama
            $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Pindahkan file ke folder public/assets/foto
            $file->move(public_path('assets/foto'), $fileName);

            // Update nama file foto di database
            $internal->foto = $fileName;
        }

        // Update data produk lainnya
        $internal->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'harga_beli' => $request->harga_beli,
        ]);

        return redirect()->route('internal')->with('success', 'internal berhasil diperbarui');
    }


    public function destroy($id)
    {
        $internal = InternalModel::findOrFail($id);

        // Cek apakah ada foto yang terkait dengan produk
        if ($internal->foto && file_exists(public_path('assets/foto/' . $internal->foto))) {
            // Hapus file foto
            unlink(public_path('assets/foto/' . $internal->foto));
        }

        // Hapus data produk dari database
        $internal->delete();

        return redirect()->route('internal')->with('success', 'internal berhasil dihapus');
    }
}
