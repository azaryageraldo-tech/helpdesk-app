<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN merupakan seorang admin
        if (auth()->check() && auth()->user()->is_admin) {
            // Jika ya, izinkan untuk melanjutkan request
            return $next($request);
        }

        // Jika tidak, hentikan proses dan tampilkan halaman error 403 (Forbidden)
        abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
    }
}