<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Doctor;
use App\Models\hospital_beds;
use App\Models\logs;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\staff_schedules;
use App\Models\treatment_categories;
use App\Models\treatments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function doctorpost(Request $request)
    {
        return response()->json([
            'data' => Doctor::create($request->all())
        ], 201);
    }

    public function patientpost(Request $request)
    {
        return response()->json([
            'data' => Patient::create($request->all())
        ], 201);
    }

    public function billingpost(Request $request)
    {
        return response()->json([
            'data' => Billing::create($request->all())
        ], 201);
    }

    public function appointmentpost(Request $request)
    {
        return response()->json([
            'data' => Appointment::create($request->all())
        ], 201);
    }

    public function staffpost(Request $request)
    {
        return response()->json([
            'data' => Staff::create($request->all())
        ], 201);
    }

    public function hospitalBedspost(Request $request)
    {
        return response()->json([
            'data' => hospital_beds::create($request->all())
        ], 201);
    }

    public function treatmentspost(Request $request)
    {
        return response()->json([
            'data' => treatments::create($request->all())
        ], 201);
    }

    public function staffSchedulepost(Request $request)
    {
        return response()->json([
            'data' => staff_schedules::create($request->all())
        ], 201);
    }

    public function treatmentCategoriespost(Request $request)
    {
        return response()->json([
            'data' => treatment_categories::create($request->all())
        ], 201);
    }

    public function logspost(Request $request)
    {
        return response()->json([
            'data' => logs::create($request->all())
        ], 201);
    }

    public function userpost(Request $request)
    {
        $salt = bin2hex(random_bytes(16));

        DB::table('users')->insert([
            'username' => $request->username,
            'password' => password_hash($request->password . $salt, PASSWORD_DEFAULT),
            'salt' => $salt,
            'role' => $request->role,
        ]);

        return response()->json([
            'message' => 'User berhasil ditambahkan'
        ], 201);
    }
}
