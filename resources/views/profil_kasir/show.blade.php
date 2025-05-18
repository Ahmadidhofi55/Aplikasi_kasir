@extends('layouts.tablekasir')
@section('title', 'Show Profile')
@section('content')
    <!-- Navbar Header -->
   <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <div class="navbar-brand text-dark fw-bold">
            <a href="{{ url()->previous() }}">
                <i class="fa fa-caret-square-left me-2"></i> Profile
            </a>
        </div>
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('/assets/img/profile.jpg') }}" alt="..." class="avatar-img rounded-circle">
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
                                    <img src="{{ Auth::user()->img ? asset('storage/' . Auth::user()->img) : asset('/assets/img/profile.jpg') }}" alt="image profile" class="avatar-img rounded">
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
                    <h4 class="mb-0">Profil Pengguna</h4>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">← Kembali</a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body row">
                        <div class="col-md-4 text-center mb-3">
                            @if ($user2->img)
                                <img src="{{ asset('storage/' . $user2->img) }}" alt="Foto Profil"
                                    class="img-fluid rounded-circle shadow" style="max-width: 150px;">
                            @else
                                <img src="/assets/img/profile.jpg" alt="Foto Default"
                                    class="img-fluid rounded-circle shadow" style="max-width: 150px;">
                            @endif
                            <h5 class="mt-3">{{ $user2->nama_lengkap }}</h5>
                            <span class="text-muted">{{ $user2->email }}</span>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>: {{ $user2->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th>Username</th>
                                    <td>: {{ $user2->username }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>: {{ $user2->email }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Pengguna</th>
                                    <td>: {{ $user2->type == 1 ? 'Kasir' : 'Admin' }}</td>
                                </tr>
                            </table>

                            <div class="mt-3 text-end">
                                <a href="{{ route('profile.kasir.edit', $user2->id) }}" class="btn btn-primary">
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
