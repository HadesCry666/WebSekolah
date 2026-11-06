<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.index');
        }

        $user = Auth::user();

        if (!in_array($user->role, $roles)) {
            // Jika siswa mencoba buka halaman admin
            if ($user->role === 'siswa') {
                return redirect()->route('siswa.raport.index')
                    ->with('error', 'Anda tidak memiliki hak akses ke halaman admin.');
            }

            // Jika admin mencoba buka dashboard siswa
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
