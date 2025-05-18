<?php
namespace App\Http\Controllers;

use App\Models\transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class Laporan_penjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Tampilkan halaman laporan
    public function index(Request $request)
    {
        $transaksis = Transaksi::with(['user', 'metodePembayaran'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan_penjualan.index', compact('transaksis'));
    }

     public function index2(Request $request)
    {
        $transaksis2 = Transaksi::with(['user', 'metodePembayaran'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('laporan_penjualan_kasir.index', compact('transaksis2'));
    }

    public function exportPdf(Request $request)
    {
        $transaksis = Transaksi::with(['user', 'metodePembayaran'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

       $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'request'));
        return $pdf->download('laporan-penjualan.pdf');
    }

     public function exportPdf2(Request $request)
    {
        $transaksis = Transaksi::with(['user', 'metodePembayaran'])
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                $query->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59',
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

       $pdf = Pdf::loadView('laporan.pdf', compact('transaksis', 'request'));
        return $pdf->download('laporan-penjualan.pdf');
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
