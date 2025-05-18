@extends('layouts.tablekasir')
@section('title', 'Edit Profile')
@section('content')
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-brand text-dark fw-bold">
                <a href="{{ route('kasir.dash') }}">
                    <i class="fa fa-caret-square-left me-2"></i> Profile
                </a>
            </div>
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('/assets/img/profile.jpg') }}"
                                alt="..." class="avatar-img rounded-circle">
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hi,</span> <span class="fw-bold">{{ Auth::user()->username }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('/assets/img/profile.jpg') }}"
                                            alt="image profile" class="avatar-img rounded">
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ Auth::user()->nama_lengkap }}</h4>
                                        <p class="text-muted">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <div class="d-flex justify-content-center my-3">
                                    <a href="#" class="btn btn-rounded btn-secondary w-100" style="max-width: 300px;"
                                        onclick="event.preventDefault(); document.getElementById('view-profile-form').submit();">
                                        Profile
                                    </a>
                                </div>

                                <form id="view-profile-form" action="{{ route('profile.kasir.show', auth()->user()->id) }}"
                                    method="GET" class="d-none">
                                    @csrf
                                </form>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <div class="d-flex justify-content-center my-2">
                                    <a href="#" class="btn btn-rounded btn-danger w-100 btn-xl"
                                        style="max-width: 300px;" onclick="confirmLogout(event)">
                                        Logout
                                    </a>
                                </div>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- End Navbar -->
    </div>
    <div class="container">
        <div class="page-inner py-4">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4>Edit Profil</h4>
                    <a href="{{ route('profile.kasir.show', $user2->id) }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('profile.kasir.update', $user2->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap"
                                        value="{{ old('nama_lengkap', $user2->nama_lengkap) }}" class="form-control">
                                    @error('nama_lengkap')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username"
                                        value="{{ old('username', $user2->username) }}" class="form-control">
                                    @error('username')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email"
                                        value="{{ old('email', $user2->email) }}" class="form-control">
                                    @error('email')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="img" class="form-label">Foto Profil</label><br>
                                    @if ($user2->img)
                                        <img src="{{ asset('storage/' . $user2->img) }}" alt="Foto"
                                            class="img-thumbnail mb-2" style="max-width: 100px;">
                                    @endif
                                    <input type="file" name="img" id="img" class="form-control">
                                    @error('img')
                                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                <a href="{{ route('profile.kasir.edit', $user2->id) }}"
                                    class="btn btn-outline-danger ms-2">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
