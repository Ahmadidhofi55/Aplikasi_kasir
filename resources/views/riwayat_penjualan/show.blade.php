@extends('layouts.table')
@section('title', 'Detail Transaksi')
@section('content')
    <style>
        html,
        body {
            height: 100%;
            overflow: auto;
        }

        .kasir-scroll-wrapper {
            max-height: 100vh;
            overflow-y: auto;
            padding-bottom: 100px;
        }
    </style>
    <div class="kasir-scroll-wrapper">
        <div class="container">
            <div class="page-inner">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Detail Transaksi</h2>
                    <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Kode:</strong> {{ $transaksi->kode_transaksi ?? 'TRX-' . $transaksi->id }}</p>
                        <p><strong>Kasir:</strong> {{ $transaksi->user->nama_lengkap ?? '-' }}</p>
                        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y H:i') }}</p>
                        <p><strong>Metode Pembayaran:</strong> {{ $transaksi->metodePembayaran->name ?? '-' }}</p>
                        <p><strong>Total:</strong> Rp{{ number_format($transaksi->total, 0, ',', '.') }}</p>
                        <p><strong>Tunai:</strong> Rp{{ number_format($transaksi->tunai, 0, ',', '.') }}</p>
                        <p><strong>Kembalian:</strong> Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</p>
                    </div>
                </div>

                <h4>Detail Produk</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi->detailTransaksis as $detail)
                                <tr>
                                    <td>{{ $detail->produk->name ?? 'Produk terhapus' }}</td>
                                    <td>Rp{{ number_format($detail->produk->harga_jual ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $detail->qty ?? $detail->jumlah }}</td>
                                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
