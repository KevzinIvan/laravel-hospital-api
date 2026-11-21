<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !(
            password_verify($request->password . $user->salt, $user->password)
            || password_verify($request->password, $user->password)
        )) {
            return response()->json([
                'error' => 'Username atau password salah'
            ], 401);
        }

        $scopes = $this->scopesFor($user->role);

        if ($user->role === 'doctor') {
            $id = Doctor::where(
                'name', 'dr. ' . ucfirst($user->username)
            )->value('id');

            if (!$id) {
                return response()->json([
                    'error' => 'Dokter tidak ditemukan'
                ], 403);
            }

            $scopes[] = "doctor_id:$id";
        }

        $user->tokens()->delete();

        $token = auth('api')->claims([
            'scopes' => $scopes
        ])->login($user);

        return response()->json([
            'token' => $token,
            'type' => 'Bearer'
        ]);
    }

    private function scopesFor($role)
    {
        if ($role === 'admin') {
            return ['*'];
        }

        $resources = [
            'patients',
            'doctors',
            'appointments',
            'treatments',
            'treatment_categories',
            'billing',
            'staff',
            'staff_schedules',
            'hospital_beds',
            'bed_admissions',
            'logs'
        ];

        $blocked = [
            'doctor' => [
                'patients',
                'staff',
                'staff_schedules',
                'hospital_beds',
                'billing',
                'logs'
            ],
            'nurse' => [
                'staff',
                'logs'
            ],
            'receptionist' => [
                'staff',
                'logs'
            ]
        ];

        $scopes = [];

        foreach ($resources as $r) {
            if (!in_array($r, $blocked[$role] ?? [])) {
                $scopes[] = "$r:read";
            }
        }

        $write = [
            'doctor' => [
                'appointments:create',
                'appointments:update',
                'treatments:create',
                'treatments:update',
                'bed_admissions:create',
                'bed_admissions:update'
            ],
            'nurse' => [
                'patients:update',
                'bed_admissions:create',
                'bed_admissions:update',
                'bed_admissions:delete',
                'hospital_beds:update'
            ],
            'receptionist' => [
                'patients:create',
                'patients:update',
                'appointments:create',
                'appointments:update',
                'billing:create'
            ]
        ];

        return array_merge($scopes, $write[$role] ?? []);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
