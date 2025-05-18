<?php
namespace App\Http\Controllers;

use App\Models\log_aktifitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query(); // atau Pengguna::query() sesuai nama model Anda

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        $pengguna = $query->paginate(5)->withQueryString();

        return view('pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        $pengguna = User::all();
        return view('pengguna.create', compact('pengguna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|email|max:255|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
            'img'          => 'nullable|image|max:2048',
            'nama_lengkap' => 'required|string|max:255',
            'type'         => 'required|in:0,1', // 0 = kasir, 1 = admin
        ]);

        $data             = $request->only(['username', 'email', 'nama_lengkap', 'type']);
        $data['password'] = Hash::make($request->password); // Hash password

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('user_images', 'public');
        }

        $user = User::create($data); // Buat user baru

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Tambah Pengguna: ' . $user->username,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('pengguna.edit', compact('users'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Ambil User berdasarkan UUID manual

        $request->validate([
            'username'     => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'password'     => 'nullable|string|min:6',
            'img'          => 'nullable|image|max:2048',
            'nama_lengkap' => 'required|string|max:255',
            'type'         => 'required|in:0,1', // 0 = kasir, 1 = admin
        ]);

        $data = $request->only(['username', 'nama_lengkap', 'email', 'type']);

        // Jika ada password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Jika ada gambar baru
        if ($request->hasFile('img')) {
            // Hapus gambar lama jika ada
            if ($user->img && Storage::disk('public')->exists($user->img)) {
                Storage::disk('public')->delete($user->img);
            }

            // Simpan gambar baru
            $data['img'] = $request->file('img')->store('user_images', 'public');
        }

        $user->update($data);

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Update Pengguna',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id); // Manual ambil berdasarkan UUID

        if ($user->img && Storage::disk('public')->exists($user->img)) {
            Storage::disk('public')->delete($user->img);
        }

        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Hapus Pengguna',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function show($id)
    {
        $users = User::findOrFail($id);
        return view('pengguna.show', compact('users'));
    }
}
