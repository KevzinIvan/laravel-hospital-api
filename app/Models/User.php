<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Pakai username bukan email (sesuai struktur DB lama)
    protected $fillable = ['username', 'password', 'salt', 'role'];
    protected $hidden   = ['password', 'salt', 'remember_token'];

    // Kasih tahu Laravel bahwa field untuk login adalah "username"
    public function getAuthIdentifierName(): string
    {
        return 'username';
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
