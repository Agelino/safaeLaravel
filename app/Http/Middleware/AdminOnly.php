<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan admin. Role Anda: ' . (Auth::user()->role ?? 'tidak ada'));
        }

        return $next($request);
    }
}
