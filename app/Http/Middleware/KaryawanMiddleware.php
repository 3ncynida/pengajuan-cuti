<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'karyawan') {
            return $next($request);
        }
        // Redirect to a different route if the user is not a karyawan
        return redirect()->route('access.denied');
    }
}