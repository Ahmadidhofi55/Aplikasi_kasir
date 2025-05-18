@extends('layouts.table')
@section('title', 'Detail Pengguna')
@section('content')
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-brand text-dark fw-bold">
                <a href="{{ url()->previous() }}">
                    <i class="fa fa-caret-square-left me-2"></i> Pengguna
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

                                <form id="view-profile-form" action="{{ route('profile.show', auth()->user()->id) }}"
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
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Pengguna</h4>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-muted small">Username</div>
                            <div class="fw-semibold">{{ $users->username }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Nama Lengkap</div>
                            <div class="fw-semibold">{{ $users->nama_lengkap }}</div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small mb-1">Gambar</div>
                            @if ($users->img)
                                <img src="{{ asset('storage/' . $users->img) }}" alt="Produk" class="img-thumbnail"
                                    style="max-width: 100px;">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ $users->email }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-muted small">Password</div>
                            <div class="fw-semibold">********</div>
                        </div>
                         <div class="col-md-4">
                            <div class="text-muted small">Type</div>
                            <div class="fw-semibold">{{ $users->type == 1 ? 'Kasir' : 'Admin' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
