<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function passwordDebug()
    {
        $passDebug = DB::table('passwd_debug')->orderByDesc('id_passwd')->value('passDebug');
        return view('backend.v_login.register', compact('passDebug'));
    }

    // public function registerBackend()
    // {
    //     $passDebug = DB::table('passwd_debug')->orderByDesc('id_passwd')->value('passDebug');
    //     return view('backend.v_login.register', compact('passDebug'));
    // }

    public function storeRegisterBackend(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'nik' => 'required|max:16',
            'email' => 'required|max:255|email',
            'role' => 'required',
            'no_hp' => 'required|min:10|max:13',
            'password' => 'required|min:4|confirmed',
        ]);

        // Cek apakah email sudah terdaftar
        if (User::where('nik', $request->nik)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nik' => 'NIK sudah terdaftar, silakan gunakan NIK lain.']);
        }

        // Cek apakah email sudah terdaftar
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Email sudah terdaftar, silakan gunakan email lain.']);
        }

        $validatedData['status'] = 1;

        // Password validation
        $password = $request->input('password');
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

        if (!preg_match($pattern, $password)) {
            return redirect()->back()->withErrors([
                'password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.'
            ]);
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);

        return redirect()->route('backend.login')
            ->with('success', 'Akun berhasil dibuat, silakan login.');
    }
}
