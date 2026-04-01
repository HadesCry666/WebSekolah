<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    // Proses login (email + password saja)
    public function login(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // CARI USER BERDASARKAN EMAIL
        $user = User::where('email', $request->email)->first();

        // CEK PASSWORD
        if ($user && Hash::check($request->password, $user->password)) {
            // Login user
            Auth::login($user, $request->boolean('remember'));

            // Simpan nama ke session (pakai name, kalau null pakai email)
            $nama = $user->name ?? $user->email;
            session(['nama' => $nama]);

            // Redirect ke satu halaman saja (dashboard)
            return redirect('/admin/tenaga-pendidik')    // ganti kalau route kamu beda
                ->with('success', 'Berhasil login');
        }

        // JIKA GAGAL
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password salah');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login.index')   // sesuaikan dengan route login kamu
            ->with('success', 'Berhasil logout!');
    }

    // Ambil nama user yang sedang login
    public function getNama()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Ambil name, kalau kosong pakai email
            return $user->name ?? $user->email;
        }

        return null; // belum login
    }
}
