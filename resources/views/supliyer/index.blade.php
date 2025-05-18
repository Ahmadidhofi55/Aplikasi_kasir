@extends('layouts.table')
@section('title', 'Supliyer')
@section('content')
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">
            <div class="navbar-brand text-dark fw-bold">
                <a href="{{ route('admin.dash') }}">
                    <i class="fa fa-caret-square-left me-2"></i> Supliyer
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                 {{-- Form Search --}}
                <form action="{{ route('supliyer.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau barcode..."
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Cari</button>
                    </div>
                </form>
                <a href="{{ route('supliyer.create') }}" class="btn btn-primary">Tambah Supliyer</a>
            </div>

               @if (request('search'))
                <div class="mb-2">
                    <small class="text-muted">
                        Ditemukan {{ $supliyer->total() }} Supliyer untuk kata kunci
                        "<strong>{{ request('search') }}</strong>"
                    </small>
                </div>
            @endif

            <div class="table-responsive" >
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Supliyer</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supliyer as $index => $item)
                            <tr>
                                <td>{{ $supliyer->firstItem() + $index }}.</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('supliyer.show', $item->id) }}"
                                                    class="dropdown-item">Lihat</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('supliyer.edit', $item->id) }}"
                                                    class="dropdown-item">Edit</a>
                                            </li>
                                             <li>
                                                <button type="button" class="dropdown-item text-danger"
                                                    onclick="deleteProduk('{{ $item->id }}')">Hapus</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data supliyer.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center">
                {{ $supliyer->links() }}
            </div>
        </div>


    </div>
    <!-- Sweet Alert -->
     <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script>
        function deleteProduk(id) {
            Swal.fire({
                title: 'Yakin hapus Supliyer ini?',
                text: 'Supliyer yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Membuat form penghapusan secara dinamis
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/produk/' + id;

                    // Menambahkan CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken;
                    form.appendChild(csrfInput);

                    // Menambahkan method DELETE
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    form.appendChild(methodInput);

                    // Menyubmit form untuk menghapus produk
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
@endsection
