<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController
{
    public function showLoginForm()
    {
        return view('login');
    }
public function login(Request $request)
{
    // 1. Validasi Input Form
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ], [
        'username.required' => 'Username wajib diisi!',
        'password.required' => 'Password wajib diisi!'
    ]);

    $credentials = $request->only('username', 'password');

    // 2. Cek Autentikasi Pengguna
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect Sesuai Peran / Role
        if ($user->role === 'bendahara') {
            return redirect()->route('dashboard.bendahara');
        } elseif ($user->role === 'walikelas') {
            return redirect()->route('dashboard.walikelas');
        } elseif ($user->role === 'siswa') {
            return redirect()->route('dashboard.siswa');
        }

        return redirect()->route('dashboard.user');
    }

    // 3. Jika Login Gagal (Username / Password Salah)
    return back()->withErrors([
        'username' => 'Username atau password yang dimasukkan salah.',
    ])->onlyInput('username');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}