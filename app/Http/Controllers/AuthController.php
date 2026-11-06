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

    // Proses login (Email/NISN + Password/NIK)
    public function login(Request $request)
    {
        // VALIDASI INPUT
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email atau NISN wajib diisi.',
            'password.required' => 'Password atau NIK wajib diisi.',
        ]);

        $loginInput = trim($request->input('email'));
        $passwordInput = $request->input('password');

        // CARI USER:
        // 1. Berdasarkan email (admin atau siswa)
        // 2. Berdasarkan username (NISN / NIS)
        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        // 3. Jika belum ketemu, cari data Siswa berdasarkan NISN atau NIS
        if (!$user) {
            $siswa = \App\Models\Siswa::where('nisn', $loginInput)
                ->orWhere('nis', $loginInput)
                ->first();

            if ($siswa && $siswa->user) {
                $user = $siswa->user;
            }
        }

        // CEK KECOCOKAN PASSWORD / NIK
        $passwordMatches = false;
        if ($user) {
            if (Hash::check($passwordInput, $user->password)) {
                $passwordMatches = true;
            } elseif ($user->role === 'siswa' && $user->siswa && $user->siswa->nik && $user->siswa->nik === $passwordInput) {
                // Sinkronkan hash password jika NIK siswa cocok
                $user->update(['password' => Hash::make($passwordInput)]);
                $passwordMatches = true;
            }
        }

        if ($user && $passwordMatches) {
            // Login user
            Auth::login($user, $request->boolean('remember'));

            // Simpan nama ke session
            $nama = $user->name ?? $user->username ?? $user->email;
            session(['nama' => $nama]);

            // Redirect berdasarkan role
            if ($user->role === 'siswa') {
                return redirect()->route('siswa.raport.index')
                    ->with('success', 'Selamat datang, ' . $nama);
            }

            return redirect()->route('admin.dashboard')
                ->with('success', 'Berhasil login');
        }

        // JIKA GAGAL
        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Kredensial salah. Pastikan NISN dan NIK (atau Email dan Password) sudah sesuai.');
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
