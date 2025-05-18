@extends('layouts.table')
@section('title', 'Edit Metode Pembayaran')

@section('content')
<div class="container">
    <div class="page-inner py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Edit Metode Pembayaran</h4>
                <a href="{{ route('metode.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>

            <div class="card shadow-sm">
                <style>
                    .card-body {
                        max-height: 500px;
                        overflow-y: auto;
                    }
                </style>
                <div class="card-body">
                    <form action="{{ route('metode.update', $metode->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nama Metode Pembayaran -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Metode Pembayaran</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $metode->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar Metode Pembayaran -->
                            <div class="col-md-6">
                                <label for="img" class="form-label">Gambar Metode Pembayaran</label><br>
                                @if ($metode->img)
                                    <img src="{{ asset('storage/' . $metode->img) }}" alt="Gambar Metode Pembayaran"
                                        class="img-thumbnail mb-2" style="max-width: 100px;">
                                @endif
                                <input type="file" class="form-control @error('img') is-invalid @enderror"
                                    id="img" name="img">
                                @error('img')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('metode.index') }}" class="btn btn-outline-danger ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
