@extends('layouts.table')
@section('title', 'Detail Produk')

@section('content')
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <div class="navbar-brand text-dark fw-bold">
            <a href="{{ url()->previous() }}">
                <i class="fa fa-caret-square-left me-2"></i> Detail Produk
            </a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="page-inner py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Produk</h4>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-muted small">Barcode</div>
                        <div class="fw-semibold">{{ $produk->barcode }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Nama Produk</div>
                        <div class="fw-semibold">{{ $produk->name }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small mb-1">Gambar</div>
                        @if ($produk->img)
                            <img src="{{ asset('storage/' . $produk->img) }}" alt="Produk"
                                class="img-thumbnail" style="max-width: 100px;">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Harga Beli</div>
                        <div class="fw-semibold">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Harga Jual</div>
                        <div class="fw-semibold">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Stok</div>
                        <div class="fw-semibold">{{ $produk->stock }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Supliyer</div>
                        <div class="fw-semibold">{{ $produk->supliyer->name ?? '-' }}</div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted small">Kategori</div>
                        <div class="fw-semibold">{{ $produk->kategori->name ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
