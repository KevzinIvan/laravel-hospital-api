<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Billing;
use App\Models\Doctor;
use App\Models\hospital_beds;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\staff_schedules;
use App\Models\treatment_categories;
use App\Models\treatments;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function doctorUpdate(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());

        return response()->json(['data' => $doctor], 200);
    }

    public function patientUpdate(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return response()->json(['data' => $patient], 200);
    }

    public function billingUpdate(Request $request, $id)
    {
        $billing = Billing::findOrFail($id);
        $billing->update($request->all());

        return response()->json(['data' => $billing], 200);
    }

    public function appointmentUpdate(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json(['data' => $appointment], 200);
    }

    public function staffUpdate(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $staff->update($request->all());

        return response()->json(['data' => $staff], 200);
    }

    public function staff_scheduleUpdate(Request $request, $id)
    {
        $schedule = staff_schedules::findOrFail($id);
        $schedule->update($request->all());

        return response()->json(['data' => $schedule], 200);
    }

    public function treatmentUpdate(Request $request, $id)
    {
        $treatment = treatments::findOrFail($id);
        $treatment->update($request->all());

        return response()->json(['data' => $treatment], 200);
    }

    public function treatment_categoriesUpdate(Request $request, $id)
    {
        $category = treatment_categories::findOrFail($id);
        $category->update($request->all());

        return response()->json(['data' => $category], 200);
    }

    public function hospital_bedsUpdate(Request $request, $id)
    {
        $bed = hospital_beds::findOrFail($id);
        $bed->update($request->all());

        return response()->json(['data' => $bed], 200);
    }
}
