<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    public function handle($request, Closure $next)
{
    if (!Auth::check()) {
        abort(403);
    }

    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    return $next($request);
}

}
