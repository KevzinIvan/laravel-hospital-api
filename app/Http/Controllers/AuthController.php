<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // POST /api/login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        $valid = false;
        if ($user) {
            if (!empty($user->salt) && password_verify($request->password . $user->salt, $user->password)) {
                $valid = true;
            } elseif (password_verify($request->password, $user->password)) {
                $valid = true;
            }
        }

        if (!$valid) {
            return response()->json(['error' => 'Username atau password salah'], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('api-token', [$user->role])->plainTextToken;

        return response()->json([
            'token' => $token,
            'role'  => $user->role,
            'user'  => $user->username,
        ]);
    }

    // POST /api/logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    // GET /api/me
    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}       

