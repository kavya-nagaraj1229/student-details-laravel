<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = $request->user(); // Sanctum user

        if (!$user || $user->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
