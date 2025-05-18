<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Laporan_penjualanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Metode_bayarController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Riwayat_penjualanController;
use App\Http\Controllers\SetttingController;
use App\Http\Controllers\SupliyerController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//bundling authentification route : login register , note *register not availiable create users in administrator
Auth::routes();

//route / not availiable , note redirect to login route
Route::redirect('/', '/login');

Route::redirect('/register', '/login');
Auth::routes(['/dashboard' => false]);
/*------------------------------------------
--------------------------------------------
All Normal Kasir Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:kasir'])->group(function () {
    Route::get('/kasir/home', [HomeController::class, 'index'])->name('kasir.dash');
    // Tampilkan data profil
    Route::get('/profile/kasir/{id}', [ProfileController::class, 'show2'])->name('profile.kasir.show')->middleware('auth');

    // Tampilkan form edit
    Route::get('/profile/kasir/edit/{id}', [ProfileController::class, 'edit2'])->name('profile.kasir.edit')->middleware('auth');

    // Proses update
    Route::put('/profile/kasir/update/{id}', [ProfileController::class, 'update2'])->name('profile.kasir.update')->middleware('auth');
    Route::get('/kasir/penjualan', [PenjualanController::class, 'index2'])->name('penjualankasir.index')->middleware('auth');
    Route::get('/kasir/riwayat-penjualan', [Riwayat_penjualanController::class, 'riwayat2'])->name('transaksi.riwayat.kasir');
    Route::get('/riwayat-penjualan/kasir/{id}', [Riwayat_penjualanController::class, 'detailRiwayat2'])->name('transaksi.riwayat.detail.kasir');
    Route::get('/laporan/penjualan/kasir', [Laporan_penjualanController::class, 'index2'])->name('laporan.penjualan.kasir');
    Route::get('/laporan/penjualan/kasir/pdf', [Laporan_penjualanController::class, 'exportPdf2'])->name('laporan.penjualan.kasir.pdf');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.dash');
    //profil
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
    Route::get('/profile/edit/{id}', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::put('/profile/update/{id}', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
    //produk resource
    Route::resource('produk', ProdukController::class)->middleware('auth');
    //supliyer resource
    Route::resource('supliyer', SupliyerController::class)->middleware('auth');
    //pengguna resource
    Route::resource('pengguna', PenggunaController::class)->middleware('auth');
    //kategori resource
    Route::resource('kategori', KategoriController::class)->middleware('auth');
    //Metode resource
    Route::resource('metode', Metode_bayarController::class)->middleware('auth');
    //Penjualan
    Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index')->middleware('auth');
    Route::post('/penjualan/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::post('/cek-barcode', [PenjualanController::class, 'cekBarcode'])->name('penjualan.cekBarcode');
    Route::post('/penjualan/simpan', [PenjualanController::class, 'simpan'])->name('penjualan.simpan');
    Route::get('/riwayat-penjualan', [Riwayat_penjualanController::class, 'riwayat'])->name('transaksi.riwayat');
    Route::get('/riwayat-penjualan/{id}', [Riwayat_penjualanController::class, 'detailRiwayat'])->name('transaksi.riwayat.detail');
    Route::get('/laporan/penjualan', [Laporan_penjualanController::class, 'index'])->name('laporan.penjualan');
    Route::get('/laporan/penjualan/pdf', [Laporan_penjualanController::class, 'exportPdf'])->name('laporan.penjualan.pdf');
    // Tampilkan data log
    Route::get('/log', [LogController::class, 'index'])->name('log.show')->middleware('auth');
    Route::get('/setting', [SetttingController::class, 'index'])->name('setting.index')->middleware('auth');
    Route::get('/setting/edit', [SetttingController::class, 'edit'])->name('setting.edit');
    Route::put('/setting/update', [SetttingController::class, 'update'])->name('setting.update');
});
