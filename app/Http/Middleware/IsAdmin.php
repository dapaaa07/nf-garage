<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika user sudah login DAN levelnya adalah 'Admin'
        if (Auth::check() && Auth::user()->level == 'Admin') {
            return $next($request); // Lanjutkan ke halaman yang dituju
        }

        // Jika tidak, tolak akses (Error 403: Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES KE HALAMAN INI.');
    }
}
