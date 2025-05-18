<?php
namespace App\Http\Controllers;

use App\Models\detail_transaksi;
use App\Models\produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validasi inputan dasar
        $request->validate([
            'produk'               => 'required|array',
            'produk.*.id'          => 'required|exists:produks,id',
            'produk.*.jumlah'      => 'required|integer|min:1',
            'metode_pembayaran_id' => 'required|exists:metode_pembayarans,id',
            'tunai'                => 'required|numeric|min:0',
            'diskon'               => 'nullable|numeric|min:0',
        ]);

        $produkData = $request->input('produk');
        $diskon     = $request->input('diskon', 0);

        // Hitung total sebelum diskon
        $total = 0;
        foreach ($produkData as $item) {
            $produk   = \App\Models\Produk::findOrFail($item['id']);
            $subtotal = $produk->harga * $item['jumlah'];
            $total += $subtotal;
        }

        // Kurangi diskon
        $totalSetelahDiskon = max(0, $total - $diskon);

        // Hitung kembalian
        $tunai     = $request->input('tunai');
        $kembalian = $tunai - $totalSetelahDiskon;
        if ($kembalian < 0) {
            return back()->withErrors(['tunai' => 'Jumlah tunai kurang dari total pembayaran.'])->withInput();
        }

        // Simpan transaksi
        $transaksi                       = new \App\Models\Transaksi();
        $transaksi->user_id              =  Auth::id();
        $transaksi->total                = $totalSetelahDiskon;
        $transaksi->tunai                = $tunai;
        $transaksi->kembalian            = $kembalian;
        $transaksi->metode_pembayaran_id = $request->input('metode_pembayaran_id');
        $transaksi->save();

        // Simpan detail transaksi
        foreach ($produkData as $item) {
            $produk = produk::findOrFail($item['id']);
            detail_transaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id'    => $produk->id,
                'jumlah'       => $item['jumlah'],
                'harga'        => $produk->harga,
                'subtotal'     => $produk->harga * $item['jumlah'],
            ]);
        }

        // Redirect ke halaman cetak struk atau halaman sukses
        return redirect()->route('penjualan.struk', $transaksi->id)
            ->with('success', 'Transaksi berhasil disimpan.');
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
