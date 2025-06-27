<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PetugasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status == 0) {
                // Jika user dinonaktifkan, logout dan redirect ke halaman login
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return redirect(route('backend.login'))->with('warning', 'Akun mu telah dinonaktifkan! Silahkan hubungi admin untuk mengaktifkan kembali akun mu.');
        }

        if (Auth::check() && Auth::user()->role == 2) { // Role 1 untuk admin
            return $next($request);
        }

        // Role 0 untuk user biasa
        // Jika ganti role ke user, logout dan redirect ke halaman login
        // elseif (Auth::check() && Auth::user()->role == 0) {

        //     Auth::logout();
        //     request()->session()->invalidate();
        //     request()->session()->regenerateToken();

        //     return redirect(route('backend.login'))->with('warning', 'Login gagal! Kamu tidak punya akses ke menu ini. Silahkan hubungi admin untuk mengaktifkan kembali akun mu.');
        // }

        // return redirect('backend/user/beranda')->with('error', 'Kamu tidak punya akses ke menu ini.');
        return redirect()->route('backend.error.404')->with('message', 'Kamu tidak punya akses ke menu ini.');
    }
}
