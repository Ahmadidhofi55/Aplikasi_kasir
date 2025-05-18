@extends('layouts.table')
@section('title', 'Tambah Metode Pembayaran')
@section('content')
    <style>
        .card-body {
            max-height: 70vh;
            overflow-y: auto;
        }
    </style>
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <a href="{{ url()->previous() }}" class="fs-4 fw-bold text-dark">
                        <i class="fa fa-caret-square-left me-2"></i> Tambah Metode Pembayaran
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('metode.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Metode Pembayaran</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="img" class="form-label">Gambar (Opsional)</label>
                                <input type="file" name="img" id="img" class="form-control">
                                @error('img')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('metode.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Metode Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
