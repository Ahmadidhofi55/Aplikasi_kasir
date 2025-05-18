<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\log_aktifitas;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    public function showLoginForm()
    {
        $setting = \App\Models\Setting::first(); // atau null
        return view('auth.login', compact('setting'));
    }

    public function redirectTo()
    {
        if (Auth::user()->type === 'admin') {
            return '/admin/home';
        }

        return '/kasir/home';
    }

    protected function authenticated(Request $request, $user)
    {
        log_aktifitas::create([
        'user_id' => $user->id,
        'aktifitas' => 'Login',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        ]);
        // Flash message untuk login berhasil
        $request->session()->flash('success', 'Login berhasil! Selamat datang kembali.');

        // Redirect ke halaman sesuai role
        return redirect($this->redirectTo());
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request)
    {
        log_aktifitas::create([
        'user_id' => Auth::id(),
        'aktifitas' => 'Logout',
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        ]);
        // Logout proses
        Auth::logout();

        // Invalidate session dan regenerate token untuk logout yang aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Flash message untuk konfirmasi logout berhasil
        $request->session()->flash('success', 'Logout berhasil.');

        // Redirect ke halaman login setelah logout
        return redirect('/login');
    }
}
