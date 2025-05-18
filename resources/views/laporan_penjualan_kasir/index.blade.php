@extends('layouts.tablekasir')
@section('title', 'Laporan Penjualan')
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
        <div class="container mt-4">
            <h3>Laporan Penjualan</h3>

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <label>Dari Tanggal:</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Sampai Tanggal:</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
                </div>
                <div class="col-md-3 align-self-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('laporan.penjualan.kasir') }}" class="btn btn-secondary">Reset</a>
                </div>
                <div class="col-md-3 align-self-end text-end">
                    <a href="{{ route('laporan.penjualan.kasir.pdf', request()->only(['start_date', 'end_date'])) }}"
                        class="btn btn-danger">Export PDF</a>
                </div>
            </form>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode Transaksi</th>
                        <th>Kasir</th>
                        <th>Total</th>
                        <th>Tunai</th>
                        <th>Kembalian</th>
                        <th>Metode Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis2 as $trx)
                        <tr>
                            <td>{{ $trx->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ $trx->user->username ?? '-' }}</td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($trx->tunai, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                            <td>{{ $trx->metodePembayaran->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
