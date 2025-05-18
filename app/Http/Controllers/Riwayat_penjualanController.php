<?php
namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\transaksi;
use Illuminate\Http\Request;

class Riwayat_penjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function riwayat()
    {
        $transaksi = transaksi::with(['user', 'detailTransaksis.produk', 'metodePembayaran'])
            ->latest()
            ->paginate(10);

        return view('riwayat_penjualan.index', compact('transaksi'));
    }

     public function riwayat2()
    {
        $transaksi1 = transaksi::with(['user', 'detailTransaksis.produk', 'metodePembayaran'])
            ->latest()
            ->paginate(10);

        return view('riwayat_penjualan_kasir.index', compact('transaksi1'));
    }

    public function detailRiwayat($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksis.produk', 'metodePembayaran'])->findOrFail($id);
        return view('riwayat_penjualan_kasir.index', compact('transaksi'));
    }

     public function detailRiwayat2($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksis.produk', 'metodePembayaran'])->findOrFail($id);
        return view('riwayat_penjualan_kasir.show', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
