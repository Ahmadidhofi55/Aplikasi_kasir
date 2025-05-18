<?php
namespace App\Http\Controllers;

use App\Models\metode_pembayaran;
use App\Models\setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(): View
    {
        $settings = setting::all();
       $today = Carbon::today();

        // Total penjualan hari ini
        $totalPenjualanHariIni = DB::table('transaksis')
            ->whereDate('created_at', $today)
            ->sum('total');

        // Total transaksi hari ini
        $totalTransaksiHariIni = DB::table('transaksis')
            ->whereDate('created_at', $today)
            ->count();

        // Jumlah kasir aktif hari ini (login atau aktivitas hari ini)
        $user = User::count();

        // Barang hampir habis (misalnya stok <= 5)
        $barangHampirHabis = DB::table('produks')
            ->where('stock', '<=', 5)
            ->count();

        // Jumlah supplier
        $jumlahSupplier = DB::table('supliyers')->count();

        $transaksiTerakhir = DB::table('transaksis')
            ->join('users', 'transaksis.user_id', '=', 'users.id') // disesuaikan dengan foreign key user_id dan primary key users.id
            ->orderByDesc('transaksis.created_at')
            ->limit(3)
            ->get([
                'transaksis.id',
                'transaksis.kode_transaksi', // karena kamu pakai $table->id() jadi primary key-nya adalah `id`, bukan `id_transaksi`
                'transaksis.total',
                'transaksis.created_at',
                'users.username',
            ]);

        // Aktivitas terbaru (limit 5)
        $aktivitasTerbaru = DB::table('log_aktifitas')
            ->join('users', 'log_aktifitas.user_id', '=', 'users.id')                         // pastikan kolom user_id di log_aktifitas terhubung dengan id di users
            ->select('users.username', 'log_aktifitas.aktifitas', 'log_aktifitas.created_at') // memilih kolom yang akan ditampilkan
            ->orderByDesc('log_aktifitas.created_at')                                         // urutkan berdasarkan created_at terbaru
            ->limit(3)                                                                        // mengambil hanya 5 hasil
            ->get();

        $penjualan = DB::table('transaksis')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total_penjualan')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        $chartLabels = $penjualan->pluck('tanggal')->toArray();
        $chartData   = $penjualan->pluck('total_penjualan')->toArray();

        $metode_pembayaran = metode_pembayaran::count();
        return view('kasir', [
            'setting'=> $settings,
            'totalPenjualanHariIni' => $totalPenjualanHariIni,
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'user'                  => $user,
            'metode_pembayaran'     => $metode_pembayaran,
            'barangHampirHabis'     => $barangHampirHabis,
            'jumlahSupplier'        => $jumlahSupplier,
            'chartLabels'           => $chartLabels,
            'chartData'             => $chartData,
            'transaksiTerakhir'     => $transaksiTerakhir,
            'aktivitasTerbaru'      => $aktivitasTerbaru,
            'hariIni'               => $today->translatedFormat('d F Y'),
        ]);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome(): View
    {
        $today = Carbon::today();

        // Total penjualan hari ini
        $totalPenjualanHariIni = DB::table('transaksis')
            ->whereDate('created_at', $today)
            ->sum('total');

        // Total transaksi hari ini
        $totalTransaksiHariIni = DB::table('transaksis')
            ->whereDate('created_at', $today)
            ->count();

        // Jumlah kasir aktif hari ini (login atau aktivitas hari ini)
        $user = User::count();

        // Barang hampir habis (misalnya stok <= 5)
        $barangHampirHabis = DB::table('produks')
            ->where('stock', '<=', 5)
            ->count();

        // Jumlah supplier
        $jumlahSupplier = DB::table('supliyers')->count();

        $transaksiTerakhir = DB::table('transaksis')
            ->join('users', 'transaksis.user_id', '=', 'users.id') // disesuaikan dengan foreign key user_id dan primary key users.id
            ->orderByDesc('transaksis.created_at')
            ->limit(3)
            ->get([
                'transaksis.id',
                'transaksis.kode_transaksi', // karena kamu pakai $table->id() jadi primary key-nya adalah `id`, bukan `id_transaksi`
                'transaksis.total',
                'transaksis.created_at',
                'users.username',
            ]);

        // Aktivitas terbaru (limit 5)
        $aktivitasTerbaru = DB::table('log_aktifitas')
            ->join('users', 'log_aktifitas.user_id', '=', 'users.id')                         // pastikan kolom user_id di log_aktifitas terhubung dengan id di users
            ->select('users.username', 'log_aktifitas.aktifitas', 'log_aktifitas.created_at') // memilih kolom yang akan ditampilkan
            ->orderByDesc('log_aktifitas.created_at')                                         // urutkan berdasarkan created_at terbaru
            ->limit(3)                                                                        // mengambil hanya 5 hasil
            ->get();

        $penjualan = DB::table('transaksis')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total) as total_penjualan')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at)')
            ->get();

        $chartLabels = $penjualan->pluck('tanggal')->toArray();
        $chartData   = $penjualan->pluck('total_penjualan')->toArray();

        $metode_pembayaran = metode_pembayaran::count();
        return view('admin', [
            'totalPenjualanHariIni' => $totalPenjualanHariIni,
            'totalTransaksiHariIni' => $totalTransaksiHariIni,
            'user'                  => $user,
            'metode_pembayaran'     => $metode_pembayaran,
            'barangHampirHabis'     => $barangHampirHabis,
            'jumlahSupplier'        => $jumlahSupplier,
            'chartLabels'           => $chartLabels,
            'chartData'             => $chartData,
            'transaksiTerakhir'     => $transaksiTerakhir,
            'aktivitasTerbaru'      => $aktivitasTerbaru,
            'hariIni'               => $today->translatedFormat('d F Y'),
        ]);

    }
}
