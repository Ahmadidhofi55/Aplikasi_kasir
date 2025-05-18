@extends('layouts.table')
@section('title', 'Edit Pengguna')
@section('content')
    <div class="container">
        <div class="page-inner py-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Edit Pengguna</h4>
                    <a href="{{ route('pengguna.index') }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card shadow-sm">
                    <style>
                        .card-body {
                            max-height: 500px;
                            overflow-y: auto;
                        }
                    </style>
                    <div class="card-body">
                        <form action="{{ route('pengguna.update', $users->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Username -->
                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username', $users->username) }}">
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $users->nama_lengkap) }}">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $users->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password (opsional)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Isi jika ingin mengganti password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="col-md-6">
                                    <label for="type" class="form-label">Tipe Pengguna</label>
                                    @php
                                        $types = [
                                            0 => 'Kasir',
                                            1 => 'Admin',
                                        ];
                                    @endphp

                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror">
                                        @foreach ($types as $key => $label)
                                            <option value="{{ $key }}"
                                                {{ old('type', $users->type) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <!-- Gambar -->
                                <div class="col-md-6">
                                    <label for="img" class="form-label">Foto Profil</label><br>
                                    @if ($users->img)
                                        <img src="{{ asset('storage/' . $users->img) }}" alt="Foto Profil"
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
                                <a href="{{ route('pengguna.index') }}" class="btn btn-outline-danger ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
