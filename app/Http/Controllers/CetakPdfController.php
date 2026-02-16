<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
// Gunakan namespace lengkap dari Fassad PDF
use Barryvdh\DomPDF\Facade\Pdf;

class CetakPdfController extends Controller
{
    /**
     * Fungsi helper untuk menemukan produk dari tabel yang berbeda.
     * Logika ini sudah diperbaiki untuk menangani tipe produk yang tidak valid.
     */
    private function findProduct($type, $id)
    {
        // 1. Dapatkan nama pendek model dari tipe produk
        $modelShortName = match (strtolower($type ?? '')) { // Gunakan null coalescing untuk keamanan
            'oli' => 'Oli',
            'rem' => 'RemModel',
            'internal' => 'InternalModel',
            'lainnya' => 'LainnyaModel',
            default => null,
        };

        // 2. Jika tidak ada nama model yang cocok, jangan lanjutkan.
        if (!$modelShortName) {
            return null;
        }

        // 3. Gabungkan namespace dengan nama model yang valid
        $modelName = 'App\\Models\\' . $modelShortName;

        // 4. Lakukan pencarian
        return $modelName::find($id);
    }

    /**
     * Membuat dan men-download PDF untuk transaksi tertentu.
     */
    public function cetakStruk($transaction_id)
    {
        // 1. Ambil data transaksi beserta relasi user dan detailnya
        $transaction = TransactionModel::with('user', 'details')->findOrFail($transaction_id);

        // 2. Ambil detail nama produk untuk setiap item di detail transaksi
        foreach ($transaction->details as $detail) {
            $product = $this->findProduct($detail->product_type, $detail->product_id);
            // Tambahkan nama produk ke objek detail untuk ditampilkan di view
            $detail->nama_produk = $product ? $product->nama : 'Produk Tidak Ditemukan';
        }

        // 3. Muat view PDF dengan data transaksi
        $pdf = Pdf::loadView('admin.transaksi_pdf', compact('transaction'));

        // 4. Atur nama file dan kirim sebagai download
        return $pdf->download('struk-' . $transaction->kode_transaksi . '.pdf');
    }
}
