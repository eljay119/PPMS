<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect users based on role
                if (Auth::user()->role === 'admin') {
                    return redirect('/admin/dashboard');
                }
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
