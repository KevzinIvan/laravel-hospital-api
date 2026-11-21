<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Billing;
use App\Models\Appointment;
use App\Models\Staff;
use App\Models\hospital_beds;
use App\Models\treatments;
use App\Models\staff_schedules;
use App\Models\treatment_categories;
use App\Models\logs;
use App\Models\User;

class ctrlcontroller extends Controller
{
    public function doctorget()
    {
        $user = auth('api')->user();

        if ($user->role === 'doctor') {
            $doctorId = Doctor::where(
                'name',
                'dr. ' . ucfirst($user->username)
            )->value('id');

            if (!$doctorId) {
                return response()->json([
                    'error' => 'Dokter tidak ditemukan'
                ], 403);
            }

            return response()->json([
                'data' => Doctor::where('id', $doctorId)->get()
            ]);
        }

        return response()->json([
            'data' => Doctor::all()
        ]);
    }

    public function patientget()
    {
        return response()->json([
            'data' => Patient::all()
        ]);
    }

    public function billingget()
    {
        return response()->json([
            'data' => Billing::all()
        ]);
    }

    public function appointmentget()
    {
        $user = auth('api')->user();

        if ($user->role === 'doctor') {
            $doctorId = Doctor::where(
                'name',
                'dr. ' . ucfirst($user->username)
            )->value('id');

            if (!$doctorId) {
                return response()->json([
                    'error' => 'Dokter tidak ditemukan'
                ], 403);
            }

            return response()->json([
                'data' => Appointment::where(
                    'doctor_id',
                    $doctorId
                )->get()
            ]);
        }

        return response()->json([
            'data' => Appointment::all()
        ]);
    }

    public function staffget()
    {
        return response()->json([
            'data' => Staff::all()
        ]);
    }

    public function hospitalBedsget()
    {
        return response()->json([
            'data' => hospital_beds::all()
        ]);
    }

    public function treatmentsget()
    {
        return response()->json([
            'data' => treatments::all()
        ]);
    }

    public function staffScheduleget()
    {
        return response()->json([
            'data' => staff_schedules::all()
        ]);
    }

    public function treatmentCategoriesget()
    {
        return response()->json([
            'data' => treatment_categories::all()
        ]);
    }

    public function logsget()
    {
        return response()->json([
            'data' => logs::all()
        ]);
    }

    public function userget()
    {
        return response()->json([
            'data' => User::all()
        ]);
    }
}
