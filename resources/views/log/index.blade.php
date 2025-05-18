@extends('layouts.table')
@section('title', 'Log Aktifitas')
@section('content')
<style>
    td, th {
        white-space: nowrap;
    }
</style>

   <!-- Navbar Header -->
<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <div class="navbar-brand text-dark fw-bold">
            <a href="{{ route('admin.dash') }}">
                <i class="fa fa-caret-square-left me-2"></i> Log Aktivitas
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
                                <form id="view-profile-form" action="{{ route('profile.show', auth()->user()->id) }}" method="GET" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <div class="d-flex justify-content-center my-2">
                                <a href="#" class="btn btn-rounded btn-danger w-100 btn-xl"
                                    style="max-width: 300px;" onclick="confirmLogout(event)">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- End Navbar -->

<div class="container">
    <div class="page-inner py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Log Aktivitas</h4>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <!-- Scrollable table wrapper -->
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Aktivitas</th>
                                <th>IP Address</th>
                                <th>User Agent</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($log as $index => $item)
                                <tr>
                                    <td>{{ $log->firstItem() + $index }}</td>
                                    <td>{{ $item->user->username ?? '-' }}</td>
                                    <td>{{ $item->aktifitas }}</td>
                                    <td>{{ $item->ip_address }}</td>
                                    <td style="min-width: 300px;">{{ $item->user_agent }}</td>
                                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada log ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $log->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
