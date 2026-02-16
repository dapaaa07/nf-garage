<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionModel;
use App\Models\TransactionDetailsModel;
// Import semua model produk Anda
use App\Models\Oli;
use App\Models\RemModel;
use App\Models\InternalModel;
use App\Models\LainnyaModel;

class TransactionController extends Controller
{
    /**
     * Menyimpan transaksi baru dari kasir ke database.
     */
    public function store(Request $request)
    {
        // Pastikan ada item di keranjang sebelum memulai
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['message' => 'Keranjang belanja kosong!'], 422);
        }

        // Gunakan DB::transaction untuk memastikan semua query berhasil atau tidak sama sekali
        DB::beginTransaction();
        try {
            // 1. Hitung total harga dari sisi server untuk keamanan
            $totalHarga = 0;
            foreach ($cart as $item) {
                $harga = is_numeric($item['harga']) ? $item['harga'] : 0;
                $kuantitas = is_numeric($item['kuantitas']) ? $item['kuantitas'] : 0;
                $totalHarga += $harga * $kuantitas;
            }

            // 2. Ambil data pembayaran dan hitung kembalian
            $jumlahBayar = (int) $request->input('jumlah_bayar', $totalHarga);
            $kembalian = $jumlahBayar - $totalHarga;

            if ($jumlahBayar < $totalHarga) {
                throw new \Exception('Jumlah pembayaran kurang dari total harga.');
            }

            $transaction = TransactionModel::create([
                'user_id' => Auth::id(),
                'kode_transaksi' => 'TRX-' . time() . '-' . Auth::id(),
                'total_harga' => $totalHarga,
                'jumlah_bayar' => $jumlahBayar,
                'kembalian' => $kembalian,
            ]);

            foreach ($cart as $id => $item) {
                if (!isset($item['product_id'], $item['product_type'], $item['nama'])) {
                     throw new \Exception('Data item di keranjang tidak lengkap.');
                }

                $subtotal = $item['harga'] * $item['kuantitas'];

                TransactionDetailsModel::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['product_id'],   // ID produk dari tabel aslinya
                    'product_type'   => $item['product_type'], // Tipe/kategori produk (cth: 'oli', 'rem')
                    'nama_produk'    => $item['nama'],         // Nama produk saat transaksi (solusi dari masalah sebelumnya)
                    'harga_satuan'   => $item['harga'],
                    'kuantitas'      => $item['kuantitas'],
                    'subtotal'       => $subtotal,
                ]);

                // 5. Kurangi stok dari tabel yang sesuai
                $modelClass = match (strtolower($item['product_type'])) {
                    'oli' => Oli::class,
                    'rem' => RemModel::class,
                    'internal' => InternalModel::class,
                    'lainnya' => LainnyaModel::class,
                    default => null,
                };

                if ($modelClass) {
                    $product = $modelClass::find($item['product_id']);
                    if ($product) {
                        if ($product->stok < $item['kuantitas']) {
                            throw new \Exception('Stok untuk produk "' . $product->nama . '" tidak mencukupi.');
                        }
                        $product->stok -= $item['kuantitas'];
                        $product->save();
                    } else {
                        throw new \Exception('Produk "' . $item['nama'] . '" tidak ditemukan di database.');
                    }
                } else {
                    throw new \Exception('Tipe produk "' . $item['product_type'] . '" tidak valid.');
                }
            }

            // 6. Jika semua berhasil, commit perubahan ke database
            DB::commit();
            session()->forget('cart');

            // 7. Beri respons sukses
            return response()->json([
                'message' => 'Transaksi berhasil disimpan!',
                'redirect_url' => route('kasir.index')
            ]);

        } catch (\Exception $e) {
            // Jika terjadi error di mana pun, batalkan semua query
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
