<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
        'judul' => 'Login',
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                return back()->with('error', 'User telah dinonaktifkan, silakan hubungi admin.');
            }

            $request->session()->regenerate();
            $userName = Auth::user()->nama;

            if (Auth::user()->role == 0) { // Login User
                return redirect()->route('backend.beranda.user')->with('success', 'Selamat datang ' . $userName);
            }
            if (Auth::user()->role == 1) { // Login Admin
                return redirect()->route('backend.beranda')->with('success', 'Selamat datang ' . $userName);
            }
            if (Auth::user()->role == 2) { // Login Petugas
                return redirect()->route('backend.petugas.dashboard')->with('success', 'Selamat datang ' . $userName);
            }
        }

        return back()->with('error', 'Login Gagal');
    }

    public function logoutBackend()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login'));
    }
}
