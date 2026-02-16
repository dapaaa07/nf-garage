<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    // Fungsi untuk menemukan produk dari tabel yang berbeda
    private function findProduct($type, $id)
    {
        $modelName = 'App\\Models\\' . match (strtolower($type)) {
            'oli' => 'Oli',
            'rem' => 'RemModel',
            'internal' => 'InternalModel',
            'lainnya' => 'LainnyaModel',
            default => null,
        };

        if (!$modelName || !class_exists($modelName)) {
            return null;
        }

        return $modelName::find($id);
    }

    // Fungsi untuk menambah produk ke keranjang
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_type' => 'required|string',
        ]);

        $product = $this->findProduct($request->product_type, $request->product_id);

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $cart = session()->get('cart', []);
        $cartId = strtolower($request->product_type) . '-' . $request->product_id; // Membuat ID unik untuk keranjang

        if (isset($cart[$cartId])) {
            // Jika produk sudah ada, tambah kuantitasnya
            if ($cart[$cartId]['kuantitas'] < $product->stok) {
                $cart[$cartId]['kuantitas']++;
            }
        } else {
            // Jika produk belum ada, tambahkan ke keranjang
            $cart[$cartId] = [
                "nama" => $product->nama,
                "kuantitas" => 1,
                "harga" => $product->harga,
                "foto" => $product->foto,
                "stok" => $product->stok,
                "product_id" => $product->id,
                "product_type" => strtolower($request->product_type),
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'message' => 'Produk berhasil ditambahkan!',
            'cart' => session()->get('cart'),
            'total' => $this->calculateTotal()
        ]);
    }

    // Fungsi untuk mengubah kuantitas item
    public function update(Request $request, $cart_id)
    {
        $request->validate([
            'amount' => 'required|integer|in:-1,1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$cart_id])) {
            $item = $cart[$cart_id];
            $product = $this->findProduct($item['product_type'], $item['product_id']);

            if (!$product) {
                unset($cart[$cart_id]);
                session()->put('cart', $cart);
                return response()->json(['message' => 'Produk asli tidak ada, item dihapus.'], 404);
            }

            $newQuantity = $item['kuantitas'] + $request->amount;

            if ($request->amount > 0 && $newQuantity > $product->stok) {
                return response()->json(['message' => 'Stok tidak mencukupi!'], 422);
            }

            if ($newQuantity <= 0) {
                unset($cart[$cart_id]);
            } else {
                $cart[$cart_id]['kuantitas'] = $newQuantity;
            }

            session()->put('cart', $cart);

            return response()->json([
                'message' => 'Keranjang diperbarui!',
                'cart' => session()->get('cart'),
                'total' => $this->calculateTotal()
            ]);
        }

        return response()->json(['message' => 'Item tidak ditemukan.'], 404);
    }

    // Fungsi untuk mengambil isi keranjang
    public function index()
    {
        return response()->json([
            'cart' => session()->get('cart', []),
            'total' => $this->calculateTotal()
        ]);
    }

    // Helper untuk menghitung total (pajak dihapus)
    private function calculateTotal()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['harga'] * $item['kuantitas'];
        }

        $total = $subtotal;

        return [
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'total' => number_format($total, 0, ',', '.'),
        ];
    }
}
