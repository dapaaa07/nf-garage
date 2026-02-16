<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionModel;
use App\Models\Pengeluaran; // 1. Tambahkan model Pengeluaran
use App\Models\PengeluaranModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Membuat dan mencetak laporan keuangan bulanan dalam format PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cetakLaporanKeuangan(Request $request)
    {
        // Validasi input bulan dan tahun
        $validated = $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];

        // Ambil data transaksi penjualan
        $transactions = TransactionModel::with(['details.productable'])
            ->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Ambil data pengeluaran lainnya pada periode yang sama
        $pengeluaranItems = PengeluaranModel::whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan)
            ->orderBy('created_at', 'asc')
            ->get();

        // Olah data transaksi penjualan
        $laporanItems = $transactions->flatMap(function ($transaction) {

            // --- PERBAIKAN DI SINI ---
            // Ganti '$transaction->items' menjadi '$transaction->details'
            return $transaction->details->map(function ($item) use ($transaction) {

                // Tambahkan pengecekan apakah 'productable' ada (sudah di-load)
                if (!$item->productable || !isset($item->productable->harga_beli)) {
                    // Jika productable null atau tidak ada harga_beli, lewati item ini
                    return null;
                }

                $kuantitas = $item->kuantitas;
                $totalHargaJual = $item->subtotal;
                $totalHargaBeli = $item->productable->harga_beli * $kuantitas;

                return [
                    'tanggal'     => $transaction->created_at->format('d-m-Y'),
                    'nama_produk' => $item->nama_produk,
                    'kuantitas'   => $kuantitas,
                    'harga_jual'  => $totalHargaJual,
                    'harga_beli'  => $totalHargaBeli,
                    'keuntungan'  => $totalHargaJual - $totalHargaBeli,
                ];
            });
        })->filter();

        // 3. Lakukan kalkulasi baru
        $totalPendapatan = $laporanItems->sum('harga_jual');
        $totalModalProduk = $laporanItems->sum('harga_beli'); // Harga Pokok Penjualan (HPP)
        $totalPengeluaranLain = $pengeluaranItems->sum('total_harga'); // Total biaya lain-lain

        $totalBiayaOperasional = $totalModalProduk + $totalPengeluaranLain; // Total modal + pengeluaran
        $labaBersih = $totalPendapatan - $totalBiayaOperasional; // Laba bersih

        // Siapkan semua data untuk dikirim ke view PDF
        $namaBulan = Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F');
        $data = [
            'tanggalCetak'          => Carbon::now()->translatedFormat('d F Y H:i'),
            'items'                 => $laporanItems,
            'pengeluaranItems'      => $pengeluaranItems, // 4. Kirim data pengeluaran ke view
            'totalPendapatan'       => $totalPendapatan,
            'totalModalProduk'      => $totalModalProduk,
            'totalPengeluaranLain'  => $totalPengeluaranLain,
            'totalBiayaOperasional' => $totalBiayaOperasional,
            'labaBersih'            => $labaBersih,
            'bulan'                 => $namaBulan,
            'tahun'                 => $tahun,
        ];

        // Buat file PDF dan kirim sebagai response stream.
        $pdfFileName = 'laporan-keuangan-' . strtolower($namaBulan) . '-' . $tahun . '.pdf';
        $pdf = PDF::loadView('admin.laporan_keuangan_pdf', $data);

        return $pdf->stream($pdfFileName);
    }
}
