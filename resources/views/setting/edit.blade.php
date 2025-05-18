@extends('layouts.table')
@section('title', 'Edit Pengaturan Aplikasi')
@section('content')
<div class="container">
    <div class="page-inner py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
             <a href="{{ route('admin.dash') }}">
                    <i class="fa fa-caret-square-left me-2"></i> Pengaturan Aplikasi
                </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                            <input type="text" name="nama_aplikasi" id="nama_aplikasi"
                                value="{{ old('nama_aplikasi', $setting->nama_aplikasi) }}"
                                class="form-control" required>
                            @error('nama_aplikasi')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="telepon" class="form-label">Telepon</label>
                            <input type="text" name="telepon" id="telepon"
                                value="{{ old('telepon', $setting->telepon) }}"
                                class="form-control">
                            @error('telepon')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" rows="3" class="form-control">{{ old('alamat', $setting->alamat) }}</textarea>
                            @error('alamat')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="logo" class="form-label">Logo</label><br>
                            @if ($setting->logo)
                                <img src="{{ asset('storage/' . $setting->logo) }}" alt="Logo"
                                    class="img-thumbnail mb-2" style="max-width: 100px;">
                            @endif
                            <input type="file" name="logo" id="logo" class="form-control">
                            @error('logo')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
