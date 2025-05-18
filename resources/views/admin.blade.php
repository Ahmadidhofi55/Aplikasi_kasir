@extends('layouts.dash')
@section('dash', 'Dashboard')
@section('content')
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-brand text-dark fw-bold">
                <a href="">
                    @yield('dash')
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
        <div class="page-inner">
            <h3 class="mb-4">Halo, {{ Auth::user()->type }} | Hari ini: {{ now()->format('d F Y') }}</h3>

            <div class="row">
                <!-- Kolom 1: Penjualan Hari Ini -->
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-body skew-shadow">
                            <h1>Rp.{{ number_format($totalPenjualanHariIni, 0, ',', '.') }}</h1>
                            <h5 class="op-8">Penjualan Hari Ini</h5>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Total Transaksi -->
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body bubble-shadow">
                            <h1>{{ $totalTransaksiHariIni }}</h1>
                            <h5 class="op-8">Total Transaksi</h5>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3: Pengguna -->
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body curves-shadow">
                            <h1>{{ $user }}</h1>
                            <h5 class="op-8">Pengguna</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Baris Kedua -->
            <div class="row mt-3">
                <!-- Kolom 4: Barang Hampir Habis -->
                <div class="col-md-4">
                    <div class="card card-secondary">
                        <div class="card-body skew-shadow">
                            <h1>{{ $barangHampirHabis }}</h1>
                            <h5 class="op-8">Produk Hampir Habis</h5>
                        </div>
                    </div>
                </div>

                <!-- Kolom 5: Jumlah Supplier -->
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body bubble-shadow">
                            <h1>{{ $jumlahSupplier }}</h1>
                            <h5 class="op-8">Jumlah Supplier</h5>
                        </div>
                    </div>
                </div>

                <!-- Kolom 6: Stok Kosong (contoh tambahan) -->
                <div class="col-md-4">
                    <div class="card card-secondary bg-secondary-gradient">
                        <div class="card-body curves-shadow">
                            <h1>{{ $metode_pembayaran }}</h1>
                            <h5 class="op-8">Metode Pembayaran</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Grafik Penjualan 7 Hari Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaksi Terakhir</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($transaksiTerakhir as $trx)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $trx->kode_transaksi }} - Rp
                                        {{ number_format($trx->total, 0, ',', '.') }}
                                        <span class="badge bg-primary">{{ $trx->username }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Aktivitas Pengguna</h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @forelse ($aktivitasTerbaru as $aktivitas)
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $aktivitas->username }}</div>
                                            {{ $aktivitas->aktifitas }}
                                        </div>
                                        <small
                                            class="text-muted">{{ \Carbon\Carbon::parse($aktivitas->created_at)->format('H:i') }}</small>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted text-center">
                                        Tidak ada aktivitas terbaru.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
