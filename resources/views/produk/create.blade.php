@extends('layouts.table')
@section('title', 'Tambah Produk')

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
                        <i class="fa fa-caret-square-left me-2"></i> Tambah Produk
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" name="barcode" id="barcode" class="form-control"
                                    value="{{ old('barcode') }}">
                                @error('barcode')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label">Gambar Produk</label>
                            <input type="file" name="img" id="img" class="form-control">
                            @error('img')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <input type="number" name="harga_beli" id="harga_beli" class="form-control"
                                    value="{{ old('harga_beli') }}">
                                @error('harga_beli')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <input type="number" name="harga_jual" id="harga_jual" class="form-control"
                                    value="{{ old('harga_jual') }}">
                                @error('harga_jual')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" name="stock" id="stock" class="form-control"
                                    value="{{ old('stock') }}">
                                @error('stock')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="supliyer_id" class="form-label">Supliyer</label>
                            <select name="supliyer_id" id="supliyer_id" class="form-select">
                                <option value="">-- Pilih Supliyer --</option>
                                @foreach ($supliyer as $s)
                                    <option value="{{ $s->id }}"
                                        {{ old('supliyer_id') == $s->id ? 'selected' : '' }}>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supliyer_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
