@extends('layouts.table')
@section('title', 'Detail Supliyer')
@section('content')
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-brand text-dark fw-bold">
                <a href="{{ url()->previous() }}">
                    <i class="fa fa-caret-square-left me-2"></i> Detail Supliyer
                </a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="page-inner py-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Supliyer</h4>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-muted small">Nama Supliyer</div>
                            <div class="fw-semibold">{{ $supliyer->name }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Telepon</div>
                            <div class="fw-semibold">{{ $supliyer->telepon }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ $supliyer->email ?? '-' }}</div>
                        </div>

                        <div class="col-md-12">
                            <div class="text-muted small">Alamat</div>
                            <div class="fw-semibold">{{ $supliyer->alamat }}</div>
                        </div>
                    </div>
                </div>

                @if ($supliyer->produks->count())
                    <div class="card-footer bg-light mt-3">
                        <h6 class="mb-3">Produk yang Disuplai:</h6>
                        <ul class="list-group">
                            @foreach ($supliyer->produks->take(4) as $produk)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $produk->name }}
                                    <span class="badge bg-secondary">Stok: {{ $produk->stock }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
