<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $accounts = [
            'admin' => 'admin',
            'doctor' => 'doctor',
            'nurse' => 'nurse',
            'receptionist' => 'receptionist',
            'tirta' => 'doctor',
            'joko' => 'doctor',
            'tia' => 'doctor',
            'titi' => 'doctor',
        ];

        foreach ($accounts as $username => $role) {
            $salt = bin2hex(random_bytes(16));
            $password = ucfirst($username).'#123';

            DB::table('users')->updateOrInsert(
                ['username' => $username],
                [
                    'password' => password_hash($password.$salt, PASSWORD_DEFAULT),
                    'salt' => $salt,
                    'role' => $role,
                ],
            );
        }
    }
}
