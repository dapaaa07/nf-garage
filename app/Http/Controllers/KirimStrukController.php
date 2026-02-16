<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\TransactionModel;
use App\Mail\StrukTransaksiMail;

class KirimStrukController extends Controller
{
    private function findProduct($type, $id)
    {
        $modelName = 'App\\Models\\' . match (strtolower($type)) {
            'oli' => 'Oli',
            'rem' => 'RemModel',
            'internal' => 'InternalModel',
            'lainnya' => 'LainnyaModel',
            default => null,
        };
        return $modelName ? $modelName::find($id) : null;
    }

    public function kirim(Request $request, $transaction_id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $transaction = TransactionModel::with('user', 'details')->findOrFail($transaction_id);

            // Ambil nama produk untuk setiap detail
            foreach ($transaction->details as $detail) {
                $product = $this->findProduct($detail->product_type, $detail->product_id);
                $detail->nama_produk = $product ? $product->nama : 'Produk Dihapus';
            }

            // Kirim email menggunakan Mailable class
            Mail::to($request->email)->send(new StrukTransaksiMail($transaction));

            return response()->json(['message' => 'Struk berhasil dikirim ke ' . $request->email]);
        } catch (\Exception $e) {
            // Log::error("Gagal kirim email: " . $e->getMessage());
            return response()->json(['message' => 'Gagal mengirim struk. Periksa konfigurasi email Anda.'], 500);
        }
    }
}
