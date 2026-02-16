<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $bulan }} {{ $tahun }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .summary-table {
            width: 50%;
            margin-left: 50%;
        }

        .summary-table td {
            border: none;
        }

        .summary-table .label {
            font-weight: bold;
        }

        .total-laba {
            font-weight: bold;
            font-size: 1.2em;
            background-color: #e8f5e9;
            /* Light green background */
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Laporan Keuangan</h1>
            <p>NF Garage</p>
            <p>Periode: {{ $bulan }} {{ $tahun }}</p>
        </div>

        <div class="section-title">Laporan Penjualan Produk</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Kuantitas</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-right">Harga Beli (Modal)</th>
                    <th class="text-right">Keuntungan Kotor</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr>
                    <td>{{ $item['tanggal'] }}</td>
                    <td>{{ $item['nama_produk'] }}</td>
                    <td>{{ $item['kuantitas'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga_jual'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga_beli'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['keuntungan'], 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data penjualan pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="section-title">Daftar Pengeluaran Lainnya</div>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th class="text-right">Total Biaya</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengeluaranItems as $item)
                <tr>
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td class="text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Tidak ada data pengeluaran pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="section-title">Ringkasan Keuangan</div>
        <table class="summary-table">
            <tr>
                <td class="label">Total Pendapatan (Penjualan)</td>
                <td class="text-right">+ Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Modal Produk (HPP)</td>
                <td class="text-right">- Rp {{ number_format($totalModalProduk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Total Pengeluaran Lainnya</td>
                <td class="text-right">- Rp {{ number_format($totalPengeluaranLain, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 1px solid #333;" class="total-laba">
                <td class="label">LABA BERSIH</td>
                <td class="text-right">Rp {{ number_format($labaBersih, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            Laporan ini dibuat secara otomatis oleh sistem pada tanggal {{ $tanggalCetak }}.
        </div>
    </div>
</body>

</html>