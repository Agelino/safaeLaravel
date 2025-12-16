<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->username !== 'adzraaditama') {
            return redirect('/')->with('error', 'Akses terbatas!');
        }

        return $next($request);
    }
}
