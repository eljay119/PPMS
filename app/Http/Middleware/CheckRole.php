<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized: User not logged in.');
        }

        $user = Auth::user();

        if (!$user->role) {
            dd("User has no role!", $user);
        }

        $userRole = $user->role->name;

        if ($userRole !== $role) {
            abort(403, 'Unauthorized: Insufficient role.');
        }

        return $next($request);
    }
}
