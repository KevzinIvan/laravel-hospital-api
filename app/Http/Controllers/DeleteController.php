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

class DeleteController extends Controller
{
    public function doctorDelete($id)
    {
        Doctor::destroy($id);

        return response()->json([
            'message' => 'Doctor deleted successfully'
        ]);
    }

    public function patientDelete($id)
    {
        Patient::destroy($id);

        return response()->json([
            'message' => 'Patient deleted successfully'
        ]);
    }

    public function billingDelete($id)
    {
        Billing::destroy($id);

        return response()->json([
            'message' => 'Billing deleted successfully'
        ]);
    }

    public function appointmentDelete($id)
    {
        Appointment::destroy($id);

        return response()->json([
            'message' => 'Appointment deleted successfully'
        ]);
    }

    public function staffDelete($id)
    {
        Staff::destroy($id);

        return response()->json([
            'message' => 'Staff deleted successfully'
        ]);
    }

    public function treatmentsDelete($id)
    {
        treatments::destroy($id);

        return response()->json([
            'message' => 'Treatments deleted successfully'
        ]);
    }

    public function treatmentCategoriesDelete($id)
    {
        treatment_categories::destroy($id);

        return response()->json([
            'message' => 'Treatment Categories deleted successfully'
        ]);
    }

    public function hospitalBedsDelete($id)
    {
        hospital_beds::destroy($id);

        return response()->json([
            'message' => 'Hospital Beds deleted successfully'
        ]);
    }

    public function staffSchedulesDelete($id)
    {
        staff_schedules::destroy($id);

        return response()->json([
            'message' => 'Staff Schedules deleted successfully'
        ]);
    }

    public function logsDelete()
    {
        logs::truncate();

        return response()->json([
            'message' => 'Logs deleted successfully'
        ]);
    }
}
