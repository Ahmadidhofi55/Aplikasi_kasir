<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\log_aktifitas;
use App\Models\metode_pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Metode_bayarController extends Controller
{
    public function index(Request $request)
    {
        $query = metode_pembayaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        $metode = $query->paginate(10)->withQueryString();

        return view('metode.index', compact('metode'));
    }

    public function create()
    {
        return view('metode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans,name',
            'img'  => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('metode_images', 'public');
        }

        $metode = metode_pembayaran::create($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Tambah Metode Pembayaran: ' . $metode->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('metode.index')->with('success', 'Metode Pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $metode = metode_pembayaran::findOrFail($id);
        return view('metode.edit', compact('metode'));
    }

    public function update(Request $request, $id)
    {
        $metode = metode_pembayaran::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:metode_pembayarans,name,' . $metode->id,
            'img'  => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('img')) {
            if ($metode->img && Storage::disk('public')->exists($metode->img)) {
                Storage::disk('public')->delete($metode->img);
            }

            $data['img'] = $request->file('img')->store('metode_images', 'public');
        }

        $metode->update($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Update Metode Pembayaran: ' . $metode->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('metode.index')->with('success', 'Metode Pembayaran berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $metode = metode_pembayaran::findOrFail($id);

        if ($metode->img && Storage::disk('public')->exists($metode->img)) {
            Storage::disk('public')->delete($metode->img);
        }

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Hapus Metode Pembayaran: ' . $metode->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $metode->delete();

        return redirect()->route('metode.index')->with('success', 'Metode Pembayaran berhasil dihapus.');
    }

    public function show($id)
    {
        $metode = metode_pembayaran::findOrFail($id);
        return view('metode.show', compact('metode'));
    }
}
