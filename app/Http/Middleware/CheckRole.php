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
    
        // Normalize both sides (remove extra spaces and lowercase)
        $userRole = strtolower(trim($user->role->name));
        $requiredRole = strtolower(trim($role));
    
        if ($userRole !== $requiredRole) {
            abort(403, "Unauthorized: Role mismatch. User role is '$userRole', required is '$requiredRole'");
        }
    
        return $next($request);
    }
    
}
