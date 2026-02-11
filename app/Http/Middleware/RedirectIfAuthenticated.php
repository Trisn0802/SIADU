<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                
                // Redirect berdasarkan role user
                if ($user->role == 0) { // User
                    return redirect()->route('backend.beranda.user');
                } elseif ($user->role == 1) { // Admin
                    return redirect()->route('backend.beranda');
                } elseif ($user->role == 2) { // Petugas
                    return redirect()->route('backend.petugas.dashboard');
                }
                
                // Fallback redirect
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
