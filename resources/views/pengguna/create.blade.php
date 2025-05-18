@extends('layouts.table')
@section('title', 'Tambah Pengguna')
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
                        <i class="fa fa-caret-square-left me-2"></i> Tambah Pengguna
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengguna.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    value="{{ old('username') }}">
                                @error('username')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control"
                                    value="{{ old('nama_lengkap') }}">
                                @error('nama_lengkap')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email') }}">
                            @error('email')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Tipe Pengguna</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="0" {{ old('type') == '0' ? 'selected' : '' }}>Kasir</option>
                                <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('type')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label">Foto Profil (Opsional)</label>
                            <input type="file" name="img" id="img" class="form-control">
                            @error('img')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
