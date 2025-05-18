@extends('layouts.table')
@section('title', 'Kasir Penjualan')
@section('content')
    <style>
        html,
        body {
            height: 100%;
            overflow: auto;
        }

        .kasir-scroll-wrapper {
            max-height: 100vh;
            overflow-y: auto;
            padding-bottom: 100px;
        }
    </style>
    <div class="kasir-scroll-wrapper">
        <div class="container py-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-cash-register me-2"></i>Kasir Penjualan</h4>
                </div>
                <div class="card-body">
                    <!-- Barcode Input -->
                    <div class="mb-4">
                        <label for="barcodeInput" class="form-label">Scan / Input Barcode</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fas fa-barcode"></i></span>
                            <input type="text" id="barcodeInput" class="form-control"
                                placeholder="Scan barcode atau masukkan kode produk" autofocus autocomplete="off">
                        </div>
                    </div>

                    <!-- Tabel Cart dibungkus dengan div scrollable -->
                    <div class="table-responsive mb-4" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-bordered table-hover" id="cartTable">
                            <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th width="40%">Nama Produk</th>
                                    <th width="20%">Harga</th>
                                    <th width="20%">Jumlah</th>
                                    <th width="15%">Subtotal</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="cartBody">
                                <!-- Cart items akan dimuat disini -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Bagian Pembayaran -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="metodePembayaran" class="form-label">Metode Pembayaran</label>
                            <select id="metodePembayaran" class="form-select">
                                <option value="">Pilih Metode Pembayaran</option>
                                @foreach ($metode as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="diskon" class="form-label">Diskon (%)</label>
                            <input type="number" id="diskon" class="form-control" min="0" max="100"
                                value="0">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <small class="text-muted">Total</small>
                                    <h4 class="mb-0" id="totalHarga">0</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tunai" class="form-label">Tunai</label>
                            <input type="number" id="tunai" class="form-control" min="0" value="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light">
                                <div class="card-body py-2">
                                    <small class="text-muted">Kembalian</small>
                                    <h4 class="mb-0" id="kembalian">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <button id="btnSimpan" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-save me-2"></i>Simpan & Cetak Struk
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script (tidak diubah fungsinya) -->
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script>
        // [TEMPATKAN SEMUA SCRIPT ASLI ANDA DI SINI]
        // Persis seperti yang Anda miliki sebelumnya
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        const cartBody = document.getElementById('cartBody');
        const totalHargaEl = document.getElementById('totalHarga');
        const diskonEl = document.getElementById('diskon');
        const tunaiEl = document.getElementById('tunai');
        const kembalianEl = document.getElementById('kembalian');
        const barcodeInput = document.getElementById('barcodeInput');
        const metodePembayaranEl = document.getElementById('metodePembayaran');

        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function renderCart() {
            cartBody.innerHTML = '';
            let total = 0;

            cart.forEach((item, index) => {
                const subtotal = item.harga * item.jumlah;
                total += subtotal;

                cartBody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.harga.toLocaleString()}</td>
                    <td>
                        <input type="number" min="1" value="${item.jumlah}" data-index="${index}" class="jumlahInput form-control" style="width: 80px;">
                    </td>
                    <td>${subtotal.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-danger btn-sm btn-hapus" data-index="${index}">Hapus</button>
                    </td>
                </tr>
                `;
            });

            updateTotal();
        }

        function updateTotal() {
            let total = cart.reduce((acc, item) => acc + (item.harga * item.jumlah), 0);
            let diskon = parseFloat(diskonEl.value) || 0;
            if (diskon < 0) diskon = 0;
            if (diskon > 100) diskon = 100;

            let totalDiskon = total * (diskon / 100);
            let totalAkhir = total - totalDiskon;

            totalHargaEl.textContent = totalAkhir.toLocaleString();

            let tunai = parseFloat(tunaiEl.value) || 0;
            let kembali = tunai - totalAkhir;
            kembalianEl.textContent = (kembali > 0 ? kembali : 0).toLocaleString();
        }

        const beepSound = new Audio('/sounds/kasir.mp3');
        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const barcode = barcodeInput.value.trim();
                if (!barcode) return;

                fetch("{{ route('penjualan.cekBarcode') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            barcode
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const produk = data.data;
                            const index = cart.findIndex(item => item.id === produk.id);
                            if (index > -1) {
                                cart[index].jumlah++;
                            } else {
                                cart.push({
                                    id: produk.id,
                                    name: produk.name,
                                    harga: produk.harga,
                                    jumlah: 1
                                });
                            }
                            saveCart();
                            renderCart();
                        } else {
                            alert(data.message || 'Produk tidak ditemukan');
                        }
                        barcodeInput.value = '';
                        barcodeInput.focus();
                    })
                    .catch(() => {
                        alert('Gagal mengecek produk');
                        barcodeInput.value = '';
                        barcodeInput.focus();
                    });
            }
        });


        cartBody.addEventListener('change', function(e) {
            if (e.target.classList.contains('jumlahInput')) {
                const idx = e.target.dataset.index;
                const val = parseInt(e.target.value);
                if (val > 0) {
                    cart[idx].jumlah = val;
                    saveCart();
                    renderCart();
                } else {
                    e.target.value = cart[idx].jumlah;
                }
            }
        });

        cartBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-hapus')) {
                const idx = e.target.dataset.index;
                cart.splice(idx, 1);
                saveCart();
                renderCart();
            }
        });

        diskonEl.addEventListener('input', updateTotal);
        tunaiEl.addEventListener('input', updateTotal);

        document.getElementById('btnSimpan').addEventListener('click', function() {
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cart Kosong',
                    text: 'Silakan tambah produk terlebih dahulu',
                });
                return;
            }
            if (!metodePembayaranEl.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Metode Pembayaran',
                    text: 'Silakan pilih metode pembayaran',
                });
                return;
            }

            let total = cart.reduce((acc, item) => acc + (item.harga * item.jumlah), 0);
            let diskon = parseFloat(diskonEl.value) || 0;
            let totalAkhir = total - (total * (diskon / 100));
            let tunai = parseFloat(tunaiEl.value) || 0;

            if (tunai < totalAkhir) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tunai Kurang',
                    text: 'Jumlah tunai kurang dari total pembayaran',
                });
                return;
            }

            const dataToSend = {
                cart: cart,
                diskon: diskon,
                total: totalAkhir,
                tunai: tunai,
                kembalian: tunai - totalAkhir,
                metode_pembayaran_id: metodePembayaranEl.value,
            };

            fetch("{{ route('penjualan.simpan') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(dataToSend)
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') {
                        printStruk(cart, totalAkhir, tunai, tunai - totalAkhir, diskon, metodePembayaranEl
                            .options[metodePembayaranEl.selectedIndex].text);
                        cart = [];
                        saveCart();
                        renderCart();
                        diskonEl.value = 0;
                        tunaiEl.value = 0;
                        kembalianEl.textContent = '0';
                        metodePembayaranEl.value = '';
                        barcodeInput.value = '';
                        barcodeInput.focus();

                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil',
                            text: 'Transaksi berhasil disimpan dan struk sudah dicetak.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menyimpan transaksi',
                        });
                    }
                })
                .catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan transaksi',
                    });
                });
        });


        function printStruk(cart, total, tunai, kembalian, diskon, metode, kodeTransaksi, namaKasir) {
            let struk = `
    <div style="font-family: monospace; max-width: 300px; margin: auto; font-size: 11px; line-height: 1.2; color: #000;">
      <div style="text-align:center; margin-bottom: 6px;">
        <div style="font-weight: bold; font-size: 14px;">{{ $setting->nama_aplikasi ?? 'Nama Toko' }}</div>
        <div>{{ $setting->alamat ?? 'Alamat Toko' }}</div>
        <div>Telp: {{ $setting->telepon ?? '-' }}</div>
      </div>

      <hr style="border: none; border-top: 1px dashed #000; margin: 6px 0;">

      <table style="width: 100%; font-size: 11px;">
        <thead>
          <tr>
            <th style="text-align:left;">Produk</th>
            <th style="text-align:right;">Qty</th>
            <th style="text-align:right;">Harga</th>
            <th style="text-align:right;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          ${cart.map(item => `
                                        <tr>
                                          <td style="text-align:left;">${item.name}</td>
                                          <td style="text-align:right;">${item.jumlah}</td>
                                          <td style="text-align:right;">${item.harga.toLocaleString()}</td>
                                          <td style="text-align:right;">${(item.jumlah * item.harga).toLocaleString()}</td>
                                        </tr>
                                      `).join('')}
        </tbody>
      </table>

      <hr style="border: none; border-top: 1px dashed #000; margin: 6px 0;">

      <table style="width: 100%; font-weight: bold; font-size: 12px;">
        <tr>
          <td>Diskon</td>
          <td style="text-align:right;">${diskon}%</td>
        </tr>
        <tr>
          <td>Total</td>
          <td style="text-align:right;">Rp ${total.toLocaleString()}</td>
        </tr>
        <tr>
          <td>Tunai</td>
          <td style="text-align:right;">Rp ${tunai.toLocaleString()}</td>
        </tr>
        <tr>
          <td>Kembalian</td>
          <td style="text-align:right;">Rp ${kembalian.toLocaleString()}</td>
        </tr>
        <tr>
          <td colspan="2" style="text-align:center; font-weight: normal; padding-top: 6px;">Pembayaran: ${metode}</td>
        </tr>
      </table>

      <hr style="border: none; border-top: 1px dashed #000; margin: 6px 0;">

      <div style="text-align:center; font-size: 10px;">
        *** TERIMA KASIH TELAH BERBELANJA ***
      </div>
      <div style="text-align:center; font-size: 9px; margin-top: 4px;">
        ${new Date().toLocaleString()}
      </div>
    </div>
  `;

            let w = window.open('', '', 'width=500,height=600');
            w.document.write(`
    <html>
      <head>
        <title>Struk Pembayaran</title>
        <style>
          body { margin: 0; padding: 10px; font-family: monospace; }
          table { border-collapse: collapse; }
          th, td { padding: 2px 4px; }
        </style>
      </head>
      <body onload="window.print(); window.close();">
        ${struk}
      </body>
    </html>
  `);
            w.document.close();
        }


        renderCart();
        updateTotal();
    </script>
@endsection
