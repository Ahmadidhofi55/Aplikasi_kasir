@extends('layouts.table')
@section('title', 'Edit Kategori')

@section('content')
<div class="container">
    <div class="page-inner py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4>Edit Kategori</h4>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">← Kembali</a>
            </div>

            <div class="card shadow-sm">
                <style>
                    .card-body {
                        max-height: 500px;
                        overflow-y: auto;
                    }
                </style>
                <div class="card-body">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nama Kategori -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $kategori->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gambar Kategori -->
                            <div class="col-md-6">
                                <label for="img" class="form-label">Gambar Kategori</label><br>
                                @if ($kategori->img)
                                    <img src="{{ asset('storage/' . $kategori->img) }}" alt="Gambar Kategori"
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
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-danger ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
