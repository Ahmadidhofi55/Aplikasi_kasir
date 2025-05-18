<?php
namespace App\Http\Controllers;

use App\Models\kategori;
use App\Models\log_aktifitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kategori::query(); // sesuaikan dengan nama model kamu (huruf besar di awal)

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
                // Tambahkan kolom lain jika ingin bisa cari berdasarkan gambar, tapi biasanya cukup 'name'
            });
        }

        $kategori = $query->paginate(5)->withQueryString();

        return view('kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name',
            'img'  => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name']);

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('kategori_images', 'public');
        }

        $kategori = Kategori::create($data);

        // Log aktivitas jika dibutuhkan
        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Tambah Kategori: ' . $kategori->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name,' . $kategori->id,
            'img'  => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name']);

        // Jika ada gambar baru
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($kategori->img && Storage::disk('public')->exists($kategori->img)) {
                Storage::disk('public')->delete($kategori->img);
            }

            // Simpan gambar baru
            $data['img'] = $request->file('img')->store('kategori_images', 'public');
        }

        $kategori->update($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Update Kategori: ' . $kategori->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        // Hapus gambar jika ada
        if ($kategori->img && Storage::disk('public')->exists($kategori->img)) {
            Storage::disk('public')->delete($kategori->img);
        }

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Hapus Kategori: ' . $kategori->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }

    public function show($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.show', compact('kategori'));
    }

}
