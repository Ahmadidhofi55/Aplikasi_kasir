@extends('layouts.table')
@section('title', 'Edit Produk')

@section('content')
    <style>
        .card-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .img-thumbnail {
            max-width: 100px;
        }
    </style>

    <div class="container">
        <div class="page-inner py-4">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="fw-bold mb-0">Edit Produk</h4>
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="barcode" class="form-label">Barcode</label>
                                <input type="text" class="form-control @error('barcode') is-invalid @enderror"
                                    id="barcode" name="barcode" value="{{ old('barcode', $produk->barcode) }}">
                                @error('barcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $produk->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="harga_beli" class="form-label">Harga Beli</label>
                                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror"
                                    id="harga_beli" name="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}">
                                @error('harga_beli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="harga_jual" class="form-label">Harga Jual</label>
                                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                    id="harga_jual" name="harga_jual" value="{{ old('harga_jual', $produk->harga_jual) }}">
                                @error('harga_jual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                    id="stock" name="stock" value="{{ old('stock', $produk->stock) }}">
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="supliyer_id" class="form-label">Supliyer</label>
                            <select name="supliyer_id" id="supliyer_id"
                                class="form-select @error('supliyer_id') is-invalid @enderror">
                                <option value="">-- Pilih Supliyer --</option>
                                @foreach ($supliyer as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('supliyer_id', $produk->supliyer_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} - {{ $item->telepon }} - {{ $item->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supliyer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori</label>
                            <select name="kategori_id" id="kategori_id"
                                class="form-select @error('kategori_id') is-invalid @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('kategori_id', $produk->kategori_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="img" class="form-label">Gambar Produk</label><br>
                            @if ($produk->img)
                                <img src="{{ asset('storage/' . $produk->img) }}" alt="Foto Produk"
                                    class="img-thumbnail mb-2">
                            @endif
                            <input type="file" class="form-control @error('img') is-invalid @enderror" id="img"
                                name="img">
                            @error('img')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('produk.index') }}" class="btn btn-outline-danger me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
