<?php
namespace App\Http\Controllers;

use App\Models\log_aktifitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile.show', compact('user'));
    }

    public function show2($id)
    {
        $user2 = User::findOrFail($id);
        return view('profil_kasir.show', compact('user2'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('profile.profile', compact('user'));
    }

      public function edit2($id)
    {
        $user2 = User::findOrFail($id);
        return view('profil_kasir.profil', compact('user2'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'email'        => 'required|email',
            'username'     => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'type'         => 'required|in:0,1',
            'img'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->store('user_images', 'public');
        }
        $user->update($data);

        // Simpan ke log_aktifitas
        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Memperbarui profil user ID ' . $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return redirect()->route('admin.dash')->with('success', 'Profil berhasil diperbarui.');
    }

    public function update2(Request $request, $id)
    {
        $user2 = User::findOrFail($id);

        $data2 = $request->validate([
            'email'        => 'required|email',
            'username'     => 'required|string|max:255',
            'nama_lengkap' => 'nullable|string|max:255',
            'img'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('img')) {
            $data2['img'] = $request->file('img')->store('user_images', 'public');
        }
        $user2->update($data2);

        // Simpan ke log_aktifitas
        log_aktifitas::create([
            'user_id'    => Auth::id(),
            'aktifitas'  => 'Memperbarui profil user ID ' . $user2->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        return redirect()->route('kasir.dash')->with('success', 'Profil berhasil diperbarui.');
    }
}
