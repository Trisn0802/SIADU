<?php

namespace App\Http\Controllers;

use App\Http\Controllers\LandingPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

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

            // CEK: Apakah user sudah verifikasi OTP?
            $user = Auth::user();
            if (!$user->otp_verified) {
                // Generate OTP baru
                $otp = \App\Models\UserOtp::generateOtp($user->id_user, 'login', 5);
                // Kirim email OTP
                Mail::to($user->email)->send(new OtpMail($otp->otp_code, $user->nama));
                // Simpan id_user ke session untuk proses OTP
                session(['otp_user_id' => $user->id_user]);
                Auth::logout();
                return redirect()->route('otp.verify.form')->with('info', 'Kode OTP telah dikirim ke email Anda. Silakan verifikasi untuk melanjutkan.');
            }

            $request->session()->regenerate();
            $userName = $user->nama;

            if ($user->role == 0) { // Login User
                return redirect()->route('backend.beranda.user')->with('success', 'Selamat datang ' . $userName);
            }
            if ($user->role == 1) { // Login Admin
                return redirect()->route('backend.beranda')->with('success', 'Selamat datang ' . $userName);
            }
            if ($user->role == 2) { // Login Petugas
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

    public function showOtpForm()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('backend.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        return view('backend.v_login.otp_verify');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|digits:1',
        ]);
        $otpInput = implode('', $request->otp);
        $userId = session('otp_user_id');
        $otp = \App\Models\UserOtp::where('id_user', $userId)
            ->where('type', 'login')
            ->where('is_verified', false)
            ->where('expired_at', '>', now())
            ->orderByDesc('id')
            ->first();
        if (!$otp || $otp->otp_code !== $otpInput) {
            return back()->with('error', 'Kode OTP salah atau sudah kadaluarsa.');
        }
        // Mark OTP as verified
        $otp->is_verified = true;
        $otp->save();
        // Mark user as verified
        $user = \App\Models\User::find($userId);
        $user->otp_verified = true;
        $user->save();
        // Login user
        Auth::login($user);
        session()->forget('otp_user_id');
        // Redirect sesuai role
        if ($user->role == 0) {
            return redirect()->route('backend.beranda.user')->with('success', 'Login berhasil!');
        }
        if ($user->role == 1) {
            return redirect()->route('backend.beranda')->with('success', 'Login berhasil!');
        }
        if ($user->role == 2) {
            return redirect()->route('backend.petugas.dashboard')->with('success', 'Login berhasil!');
        }
        return redirect()->route('backend.login');
    }
}
