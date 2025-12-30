<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
<<<<<<< HEAD
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan admin. Role Anda: ' . (Auth::user()->role ?? 'tidak ada'));
        }

        return $next($request);
=======
{
    if (!Auth::check()) {
        abort(403);
>>>>>>> 26c77087437da507f3f2334fefb60743c2dd88db
    }

    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    return $next($request);
}

}
