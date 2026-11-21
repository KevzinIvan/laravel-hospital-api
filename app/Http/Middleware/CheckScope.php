<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckScope
{
    public function handle(Request $request, Closure $next, string $ability)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $scopes = auth('api')->payload()->get('scopes') ?? [];

        if (!in_array('*', $scopes) && !in_array($ability, $scopes)) {
            return response()->json([
                'message' => 'Forbidden',
                'required_scope' => $ability
            ], 403);
        }

        return $next($request);
    }
}