<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ctrlcontroller;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',     [AuthController::class, 'me']);
});

Route::get('/doctor', [ctrlcontroller::class, 'doctorget']);

Route::get('/patient', [ctrlcontroller::class, 'patientget']);

Route::get('/billing', [ctrlcontroller::class, 'billingget']);

Route::get('/appointment', [ctrlcontroller::class, 'appointmentget']);

Route::get('/staff', [ctrlcontroller::class, 'staffget']);

Route::get('/hospital_beds', [ctrlcontroller::class, 'hospitalBedsget']);

Route::get('/treatments', [ctrlcontroller::class, 'treatmentsget']);

Route::get('/staff_schedules', [ctrlcontroller::class, 'staffScheduleget']);

Route::get('/treatment_categories', [ctrlcontroller::class, 'treatmentCategoriesget']);

Route::get('/logs', [ctrlcontroller::class, 'logsget']);

Route::get('/user', [ctrlcontroller::class, 'userget']);
