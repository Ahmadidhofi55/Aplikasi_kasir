<?php
namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;
use App\Models\log_aktifitas;
use Illuminate\Support\Facades\Auth;

class SetttingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = setting::first();
        return view('setting.index', compact('setting'));
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
    public function edit()
    {
        $setting = Setting::first(); // hanya satu data
        return view('setting.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:20',
        ]);

        $setting = Setting::first();

        if ($request->hasFile('logo')) {
            $setting['logo'] = $request->file('logo')->store('user_images', 'public');
        }

        $setting->nama_aplikasi = $request->nama_aplikasi;
        $setting->alamat        = $request->alamat;
        $setting->telepon       = $request->telepon;
        $setting->save();

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Memperbarui Pengaturan Aplikasi' ,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
          return redirect()->route('admin.dash')->with('success', 'Setting berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
