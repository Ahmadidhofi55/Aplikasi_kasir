<?php
namespace App\Http\Controllers;

use App\Models\metode_pembayaran;
use App\Models\produk;
use App\Models\setting;
use App\Models\transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function cekBarcode(Request $request)
    {
        $barcode = $request->input('barcode'); // Get the barcode from the request
        $produk  = Produk::where('barcode', $barcode)->first();

        if (! $produk) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => [
                'id'      => $produk->id,
                'name'    => $produk->name,
                'harga'   => $produk->harga_beli,
                'barcode' => $produk->barcode,
            ],
        ]);
    }

    public function index()
    {
        // Ambil metode pembayaran untuk dropdown
        $metode  = metode_pembayaran::all();
        $setting = setting::first();
        // Ambil produk dengan kolom yang dibutuhkan (termasuk barcode)
        $produk = produk::select('id', 'barcode', 'name', 'harga_jual')->get();

        return view('penjualan.index', compact('produk', 'metode', 'setting'));
    }

    //untuk kasir
       public function index2()
    {
        // Ambil metode pembayaran untuk dropdown
        $metode  = metode_pembayaran::all();
        $setting = setting::first();
        // Ambil produk dengan kolom yang dibutuhkan (termasuk barcode)
        $produk = produk::select('id', 'barcode', 'name', 'harga_jual')->get();

        return view('penjualan_kasir.index', compact('produk', 'metode', 'setting'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function simpan(Request $request)
    {
        // Validasi request
        $request->validate([
            'cart'                 => 'required|array',
            'diskon'               => 'required|numeric|min:0|max:100',
            'total'                => 'required|numeric|min:0',
            'tunai'                => 'required|numeric|min:0',
            'kembalian'            => 'required|numeric|min:0',
            'metode_pembayaran_id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Simpan transaksi utama
            $transaksi                       = new Transaksi();
            $transaksi->user_id              = Auth::id();
            $transaksi->total                = $request->total;
            $transaksi->tunai                = $request->tunai;
            $transaksi->kembalian            = $request->kembalian;
            $transaksi->metode_pembayaran_id = $request->metode_pembayaran_id;
            $transaksi->save();

            // Proses detail transaksi dan kurangi stok
            foreach ($request->cart as $item) {
                $produk = Produk::findOrFail($item['id']);

                // Cek stok cukup
                if ($produk->stock < $item['jumlah']) {
                    throw new \Exception("Stok produk {$produk->nama} tidak mencukupi.");
                }

                // Kurangi stok
                $produk->stock -= $item['jumlah'];
                $produk->save();

                // Simpan detail transaksi
                $subtotal = $item['harga'] * $item['jumlah'];
                $transaksi->detailTransaksis()->create([
                    'produk_id'  => $item['id'],
                    'qty'        => $item['jumlah'],
                    'harga_Jual' => $item['harga'],
                    'subtotal'   => $subtotal,
                ]);
            }

            DB::commit();
            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving transaction: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage() ?? 'Gagal menyimpan transaksi',
            ], 500);
        }

    }
}

/**
 * Store a newly created resource in storage.
 */
