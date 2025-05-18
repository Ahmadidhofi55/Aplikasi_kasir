<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>
    <p>Periode: {{ request('start_date') }} s/d {{ request('end_date') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Kasir</th>
                <th>Total</th>
                <th>Tunai</th>
                <th>Kembalian</th>
                <th>Metode</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $key => $trx)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                    <td>{{ $trx->kode_transaksi }}</td>
                    <td>{{ $trx->user->username ?? '-' }}</td>
                    <td>Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($trx->tunai, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                    <td>{{ $trx->metodePembayaran->name ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
