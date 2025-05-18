@extends('layouts.log')

@section('content')
    <div class="text-center mb-4">
        {{-- Ganti src dengan path logo kamu --}}
        <img src="{{ asset('/storage/'. $setting->logo ) }}" alt="Logo Aplikasi" width="150px" class="logo-img mb-2">
        <div class="app-title  fw-bold">{{ $setting->nama_aplikasi }}</div>
        <div class="text-muted small">{{ $setting->alamat }}</div>
        <div class="text-muted small">Silakan login untuk melanjutkan</div>
    </div>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
        </div>
    </form>
    @if (session('success'))
        <!-- Sweet Alert -->
        <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
