<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
{
    // Cek apakah pengguna sudah login dan role-nya sesuai
    if (auth()->check() && auth()->user()->role == $role) {
        return $next($request); // Jika sesuai, lanjutkan ke request berikutnya
    }

    // Jika tidak sesuai, beri respons 403 Forbidden
    abort(403, 'Unauthorized Access: You do not have permission to view this page.');
}

}
