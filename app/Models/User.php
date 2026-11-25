<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'jwt_token_version' => 'integer',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getAuthIdentifier();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}