<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoles
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array($request->user()->role->name, $roles)) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }
}
