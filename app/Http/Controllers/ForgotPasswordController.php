<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form untuk input email lupa password
     */
    public function showForgotPasswordForm()
    {
        return view('v_forgot_password.request', [
            'judul' => 'Lupa Password'
        ]);
    }

    /**
     * Proses permintaan reset password (kirim email)
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        // Selalu tampilkan pesan yang sama untuk keamanan (mencegah email enumeration)
        if (!$user) {
            return back()->with('success', 'Verifikasi email lupa password telah dikirim mohon di cek');
        }

        // Generate unique reset token dari UUID user
        $resetToken = Str::random(64);

        // Simpan token ke database dengan waktu expire 1 jam
        $user->update([
            'reset_token' => $resetToken,
            'reset_token_expires_at' => Carbon::now()->addHour()
        ]);

        // Kirim email dengan link reset
        try {
            Mail::send('backend.v_emails.reset_password', [
                'user' => $user,
                'resetToken' => $resetToken,
                'resetUrl' => route('password.reset.form', ['token' => $resetToken])
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->from(env('MAIL_FROM_ADDRESS'), 'SIADU')
                        ->subject('Reset Password - SIADU');
            });
        } catch (\Exception $e) {
            // Email gagal dikirim tapi tetap tampilkan pesan sukses
            Log::error('Reset password email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Verifikasi email lupa password telah dikirim mohon di cek');
    }

    /**
     * Tampilkan form untuk reset password dengan token
     */
    public function showResetPasswordForm($token)
    {
        $user = User::where('reset_token', $token)
                    ->where('reset_token_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('backend.login')
                           ->with('error', 'Link reset password tidak valid atau telah kadaluarsa');
        }

        return view('v_forgot_password.reset', [
            'judul' => 'Reset Password',
            'token' => $token,
            'email' => $user->email
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::where('reset_token', $request->token)
                    ->where('reset_token_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('backend.login')
                           ->with('error', 'Link reset password tidak valid atau telah kadaluarsa');
        }

        // Update password
        $user->update([
            'password' => bcrypt($request->password),
            'reset_token' => null,
            'reset_token_expires_at' => null
        ]);

        return redirect()->route('backend.login')
                       ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda');
    }

    /**
     * Tampilkan form untuk ganti password (dengan verifikasi password lama)
     */
    public function showChangePasswordForm($uuid, $userType = 'user')
    {
        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Jika userType tidak diberikan sebagai query parameter, coba ambil dari route
        if (!$userType || $userType === 'user') {
            // Tentukan userType berdasarkan role user
            if ($user->role == 1) {
                $userType = 'admin';
            } elseif ($user->role == 2) {
                $userType = 'petugas';
            } else {
                $userType = 'user';
            }
        }

        return view('v_forgot_password.change_password', [
            'judul' => 'Ganti Password',
            'user' => $user,
            'userType' => $userType,
            'id_user' => $uuid
        ]);
    }

    /**
     * Proses ganti password dengan verifikasi password lama
     */
    public function changePassword(Request $request, $uuid)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
            'password_baru_confirmation' => 'required'
        ], [
            'password_lama.required' => 'Password lama harus diisi',
            'password_baru.required' => 'Password baru harus diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.confirmed' => 'Konfirmasi password tidak sesuai, silakan masukkan kembali'
        ]);

        $user = User::where('uuid', $uuid)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Verifikasi password lama
        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password baru
        $user->update([
            'password' => bcrypt($request->password_baru)
        ]);

        // Tentukan route kembali berdasarkan role user
        $backRoute = match($user->role) {
            1 => 'backend.beranda',  // admin dashboard
            2 => 'backend.petugas.dashboard',  // petugas dashboard
            default => 'backend.beranda.user'  // user dashboard
        };

        return redirect()->route($backRoute)
                       ->with('success', 'Password berhasil diubah');
    }
}
