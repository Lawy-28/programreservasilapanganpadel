<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input email dan password dari form login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login dengan kredensial yang diberikan
        // Auth::attempt akan otomatis mengecek password yang di-hash
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerasi session ID untuk mencegah serangan Session Fixation
            $request->session()->regenerate();

            // Redirect user ke halaman yang mau dituju sebelumnya (intended) atau default ke dashboard
            return redirect()->intended('dashboard');
        }

        // Jika login gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Proses logout user dari sistem
        Auth::logout();

        // Invalidasi session saat ini agar tidak bisa dipakai lagi (Security)
        $request->session()->invalidate();

        // Regenerasi token CSRF baru untuk session berikutnya
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect('/login');
    }
}
