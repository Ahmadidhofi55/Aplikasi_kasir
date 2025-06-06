@extends('layouts.table')
@section('title', 'Detail Metode Pembayaran')

@section('content')
<!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <div class="navbar-brand text-dark fw-bold">
            <a href="{{ url()->previous() }}">
                <i class="fa fa-caret-square-left me-2"></i> Metode Pembayaran
            </a>
        </div>
    </div>
</nav>
<!-- End Navbar -->

<div class="container">
    <div class="page-inner py-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Detail Metode Pembayaran</h4>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="text-muted small">Nama Metode Pembayaran</div>
                        <div class="fw-semibold">{{ $metode->name }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Gambar</div>
                        @if ($metode->img)
                            <img src="{{ asset('storage/' . $metode->img) }}" alt="Metode Pembayaran"
                                 class="img-thumbnail" style="max-width: 100px;">
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
