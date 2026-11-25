<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class JwtTokenLifecycleTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_login_invalidates_the_previous_jwt(): void
    {
        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('Admin#123'),
            'role' => 'admin',
        ]);
        $credentials = [
            'username' => $user->username,
            'password' => 'Admin#123',
        ];

        $firstToken = $this->postJson('/api/login', $credentials)->assertOk()->json('token');
        $secondToken = $this->postJson('/api/login', $credentials)->assertOk()->json('token');

        JWTAuth::unsetToken();
        Auth::forgetGuards();
        $this->withToken($firstToken)->getJson('/api/me')->assertUnauthorized();

        JWTAuth::unsetToken();
        Auth::forgetGuards();
        $this->withToken($secondToken)->getJson('/api/me')->assertOk();
    }

    public function test_login_jwt_expires_after_seven_days(): void
    {
        $user = User::create([
            'username' => 'admin',
            'password' => Hash::make('Admin#123'),
            'role' => 'admin',
        ]);

        $token = $this->postJson('/api/login', [
            'username' => $user->username,
            'password' => 'Admin#123',
        ])->assertOk()->json('token');

        $payload = JWTAuth::setToken($token)->payload();

        $this->assertSame(7 * 24 * 60 * 60, $payload->get('exp') - $payload->get('iat'));
    }
}
