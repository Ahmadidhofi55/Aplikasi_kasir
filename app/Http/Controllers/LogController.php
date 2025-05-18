<?php
namespace App\Http\Controllers;

use App\Models\log_aktifitas;
use App\Models\setting;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $log = log_aktifitas::with('user')->paginate(5);
        return view('log.index', compact('log'));
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $setting = Setting::first(); // hanya satu data
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_aplikasi' => 'required|string|max:255',
            'logo'          => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'alamat'        => 'required|string',
            'telepon'       => 'required|string|max:20',
        ]);

        $setting = setting::first();

        if ($request->hasFile('logo')) {
            $logo          = $request->file('logo')->store('logo', 'public');
            $setting->logo = $logo;
        }

        $setting->nama_aplikasi = $request->nama_aplikasi;
        $setting->alamat        = $request->alamat;
        $setting->telepon       = $request->telepon;
        $setting->save();

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
