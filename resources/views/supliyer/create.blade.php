@extends('layouts.table')
@section('title', 'Tambah Supliyer')
@section('content')
    <style>
        .card-body {
            max-height: 500px;
            /* Menentukan tinggi maksimal form */
            overflow-y: auto;
            /* Mengaktifkan scroll vertikal */
        }
    </style>
    <div class="container">
        <div class="page-inner">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('supliyer.index') }}" class="fs-4 fw-bold text-dark">
                        <i class="fa fa-caret-square-left me-2"></i> Tambah Supliyer
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('supliyer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Supliyer</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" name="telepon" id="telepon" class="form-control"
                                    value="{{ old('telepon') }}">
                                @error('telepon')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat Supliyer</label>
                            <textarea name="alamat" id="alamat" class="form-control">{{ old('address') }}</textarea>
                            @error('alamat')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('supliyer.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Supliyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
