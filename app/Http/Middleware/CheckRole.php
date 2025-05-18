<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);  // Lanjutkan jika role sesuai
        }

        // Jika tidak sesuai, beri respons 403 Forbidden
        return response()->view('errors.403', [], 403); // Bisa custom halaman error 403
    }
}
