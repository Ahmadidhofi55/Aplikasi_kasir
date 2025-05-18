<?php
namespace App\Http\Controllers;

use App\Models\log_aktifitas;
use App\Models\Supliyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupliyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supliyer::query();

        // Handle search hanya pada supplier
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('telepon', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $supliyer = $query->paginate(4)->withQueryString(); // Keep search on pagination

        return view('supliyer.index', compact('supliyer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supliyer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'alamat'  => 'required|string|max:500',
            'telepon' => 'required|string|max:20',
            'email'   => 'required|email|max:255',
        ]);

        $data = $request->all(); // Menyimpan inputan lainnya ke dalam $data
        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Tambah Supliyer',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // Membuat produk baru menggunakan data yang sudah divalidasi dan diproses
        Supliyer::create($data);
        return redirect()->route('supliyer.index')->with('success', 'Supliyer berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supliyer $supliyer)
    {
        return view('supliyer.show', compact('supliyer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supliyer = Supliyer::findOrFail($id);
        return view('supliyer.edit', compact('supliyer'));
    }

    // Mengupdate data supliyer
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required',
            'alamat'  => 'required',
            'telepon' => 'required',
            'email'   => 'required|email',
        ]);

        $supliyer = Supliyer::findOrFail($id);
        $supliyer->update([
            'name'    => $request->name,
            'alamat'  => $request->alamat,
            'telepon' => $request->telepon,
            'email'   => $request->email,
        ]);

        return redirect()->route('supliyer.index')->with('success', 'Supliyer berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Hapus Supliyer',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        // Hapus produk dari database
        $request->delete();

        return redirect()->route('supliyer.index')->with('success', 'Supliyer berhasil dihapus.');
    }
}
