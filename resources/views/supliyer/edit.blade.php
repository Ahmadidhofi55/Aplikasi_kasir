@extends('layouts.table')
@section('title', 'Edit Supliyer')
@section('content')
    <div class="container">
        <div class="page-inner py-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Edit Supliyer</h4>
                    <a href="{{ route('supliyer.index') }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card shadow-sm">
                    <style>
                        .card-body {
                            max-height: 500px;
                            /* Menentukan tinggi maksimal form */
                            overflow-y: auto;
                            /* Mengaktifkan scroll vertikal */
                        }
                    </style>
                    <div class="card-body">
                        <form action="{{ route('supliyer.update', $supliyer->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Nama Supliyer -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama Supliyer</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $supliyer->name) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Alamat Supliyer -->
                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                                        id="alamat" name="alamat" value="{{ old('alamat', $supliyer->alamat) }}">
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Telepon Supliyer -->
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                        id="telepon" name="telepon" value="{{ old('telepon', $supliyer->telepon) }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Supliyer -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $supliyer->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('supliyer.index') }}" class="btn btn-outline-danger ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
