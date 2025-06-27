<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->status == 0) {
                // Jika user dinonaktifkan, logout dan redirect ke halaman login
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();

                return redirect(route('backend.login'))->with('warning', 'Akun mu telah dinonaktifkan! Silahkan hubungi admin untuk mengaktifkan kembali akun mu.');
        }

        if (Auth::check() && Auth::user()->role == 0) { // Role 0 untuk user
            return $next($request);
        }
        // Role 1 untuk admin
        // Jika user ganti role ke admin, logout dan redirect ke halaman login
        // elseif (Auth::check() && Auth::user()->role == 1) {
        //     Auth::logout();
        //     request()->session()->invalidate();
        //     request()->session()->regenerateToken();

        //     return redirect(route('backend.login'))->with('warning', 'Login gagal! Kamu tidak punya akses ke menu ini. Silahkan hubungi admin untuk mengaktifkan kembali akun mu.');
        // }

        // return redirect('backend/admin/beranda')->with('error', 'Kamu tidak punya akses ke menu ini.');
        return redirect()->route('backend.error.404')->with('message', 'Kamu tidak punya akses ke menu ini.');
    }
}
