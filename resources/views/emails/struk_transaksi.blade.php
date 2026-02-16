<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk Transaksi - {{ $transaction->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            margin-top: 20px;
            width: 40%;
            margin-left: 60%;
        }

        .total-section td {
            border: none;
            padding: 5px 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>NF Garage</h1>
            <p>Perumahan Puri Kosambi 1 Blok D. No. 52 Duren, Klari, Karawang</p>
            <p>Telepon: 0812-7260-0293</p>
        </div>

        <hr>

        <table>
            <tr>
                <td><strong>No. Transaksi:</strong></td>
                <td>{{ $transaction->kode_transaksi }}</td>
                <td><strong>Kasir:</strong></td>
                <td>{{ $transaction->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal:</strong></td>
                <td colspan="3">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
            </tr>
        </table>

        <h3>Detail Item</h3>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Kuantitas</th>
                    <th class="text-right">Harga Satuan</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->nama_produk }}</td>
                    <td>{{ $detail->kuantitas }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="total-section">
            <tr>
                <td><strong>Total Harga:</strong></td>
                <td class="text-right">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Jumlah Bayar:</strong></td>
                <td class="text-right">Rp {{ number_format($transaction->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Kembalian:</strong></td>
                <td class="text-right">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>

</html>