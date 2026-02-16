<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\DB;

class RiwayatTransaksiController extends Controller
{
    /**
     * Menampilkan halaman daftar riwayat transaksi.
     */
    public function index()
    {
        $transactions = TransactionModel::with('user')
            ->latest()
            ->paginate(10);

        // Kode ini sekarang akan berfungsi karena DB sudah di-import
        $availablePeriods = DB::table('transactions')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->distinct()
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Kirim kedua variabel ke view
        return view('admin.riwayat_transaksi', compact('transactions', 'availablePeriods'));
    }

    /**
     * Menampilkan detail satu transaksi. (Opsional, untuk pengembangan selanjutnya)
     */
    public function show($id)
    {
        // Anda bisa membuat halaman detail di sini nanti
        $transaction = TransactionModel::with('details.product')->findOrFail($id);
        // return view('admin.detail_transaksi', compact('transaction'));
    }
}
