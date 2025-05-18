<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\log_aktifitas;
use App\Models\produk;
use App\Models\Supliyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('supliyer', 'kategori');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('barcode', 'like', '%' . $search . '%')
                    ->orWhereHas('supliyer', function ($su) use ($search) {
                        $su->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kategori', function ($ka) use ($search) {
                        $ka->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        $produk = $query->paginate(4)->withQueryString();

        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $supliyer = Supliyer::all();
        $kategori = Kategori::all();
        return view('produk.create', compact('supliyer', 'kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barcode'     => 'required|unique:produks',
            'name'        => 'required',
            'img'         => 'nullable|image|max:2048',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'stock'       => 'required|numeric',
            'supliyer_id' => 'required|exists:supliyers,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('user_images', 'public');
        }

        Produk::create($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Tambah Produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $produk   = Produk::findOrFail($id);
        $supliyer = Supliyer::all();
        $kategori = Kategori::all(); // Tambahan

        return view('produk.edit', compact('produk', 'supliyer', 'kategori'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'barcode'     => 'required|unique:produks,barcode,' . $produk->id,
            'name'        => 'required',
            'img'         => 'nullable|image|max:2048',
            'harga_beli'  => 'required|numeric',
            'harga_jual'  => 'required|numeric',
            'stock'       => 'required|numeric',
            'supliyer_id' => 'required|exists:supliyers,id',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            if ($produk->img && Storage::disk('public')->exists($produk->img)) {
                Storage::disk('public')->delete($produk->img);
            }

            $data['img'] = $request->file('img')->store('user_images', 'public');
        } else {
            unset($data['img']);
        }

        $produk->update($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Update Produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Request $request, Produk $produk)
    {
        if ($produk->img && Storage::disk('public')->exists($produk->img)) {
            Storage::disk('public')->delete($produk->img);
        }

        $produk->delete();

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Hapus Produk',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Produk $produk)
    {
        $produk->load('supliyer', 'kategori');
        return view('produk.show', compact('produk'));
    }
}
