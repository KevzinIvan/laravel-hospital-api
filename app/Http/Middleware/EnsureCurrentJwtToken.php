<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCurrentJwtToken
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'error' => 'Unauthenticated. Token tidak valid atau tidak ada.',
            ], 401);
        }

        $tokenVersion = JWTAuth::setToken($request->bearerToken())
            ->payload()
            ->get('token_version');

        if (!is_numeric($tokenVersion) || (int) $tokenVersion !== $user->jwt_token_version) {
            return response()->json([
                'error' => 'Token tidak berlaku lagi.',
            ], 401);
        }

        return $next($request);
    }
}
