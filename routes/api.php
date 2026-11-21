
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ctrlcontroller;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\UpdateController;

// LOGIN
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    // AUTH
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // GET
    Route::get('/doctor', [ctrlcontroller::class, 'doctorget'])->middleware('scope:doctors:read');
    Route::get('/patient', [ctrlcontroller::class, 'patientget'])->middleware('scope:patients:read');
    Route::get('/billing', [ctrlcontroller::class, 'billingget'])->middleware('scope:billing:read');
    Route::get('/appointment', [ctrlcontroller::class, 'appointmentget'])->middleware('scope:appointments:read');
    Route::get('/staff', [ctrlcontroller::class, 'staffget'])->middleware('scope:staff:read');
    Route::get('/hospital_beds', [ctrlcontroller::class, 'hospitalBedsget'])->middleware('scope:hospital_beds:read');
    Route::get('/treatments', [ctrlcontroller::class, 'treatmentsget'])->middleware('scope:treatments:read');
    Route::get('/staff_schedules', [ctrlcontroller::class, 'staffScheduleget'])->middleware('scope:staff_schedules:read');
    Route::get('/treatment_categories', [ctrlcontroller::class, 'treatmentCategoriesget'])->middleware('scope:treatment_categories:read');
    Route::get('/logs', [ctrlcontroller::class, 'logsget'])->middleware('scope:logs:read');
    Route::get('/user', [ctrlcontroller::class, 'userget'])->middleware('scope:users:read');

    // POST
    Route::post('/doctor', [PostController::class, 'doctorpost'])->middleware('scope:doctors:create');
    Route::post('/patient', [PostController::class, 'patientpost'])->middleware('scope:patients:create');
    Route::post('/billing', [PostController::class, 'billingpost'])->middleware('scope:billing:create');
    Route::post('/appointment', [PostController::class, 'appointmentpost'])->middleware('scope:appointments:create');
    Route::post('/staff', [PostController::class, 'staffpost'])->middleware('scope:staff:create');
    Route::post('/hospital_beds', [PostController::class, 'hospitalBedspost'])->middleware('scope:hospital_beds:create');
    Route::post('/treatments', [PostController::class, 'treatmentspost'])->middleware('scope:treatments:create');
    Route::post('/staff_schedules', [PostController::class, 'staffSchedulepost'])->middleware('scope:staff_schedules:create');
    Route::post('/treatment_categories', [PostController::class, 'treatmentCategoriespost'])->middleware('scope:treatment_categories:create');
    Route::post('/logs', [PostController::class, 'logspost'])->middleware('scope:logs:create');
    Route::post('/user', [PostController::class, 'userpost'])->middleware('scope:users:create');

    // DELETE
    Route::delete('/doctor/{id}', [DeleteController::class, 'doctorDelete'])->middleware('scope:doctors:delete');
    Route::delete('/patient/{id}', [DeleteController::class, 'patientDelete'])->middleware('scope:patients:delete');
    Route::delete('/billing/{id}', [DeleteController::class, 'billingDelete'])->middleware('scope:billing:delete');
    Route::delete('/appointment/{id}', [DeleteController::class, 'appointmentDelete'])->middleware('scope:appointments:delete');
    Route::delete('/staff/{id}', [DeleteController::class, 'staffDelete'])->middleware('scope:staff:delete');
    Route::delete('/treatments/{id}', [DeleteController::class, 'treatmentsDelete'])->middleware('scope:treatments:delete');
    Route::delete('/treatment_categories/{id}', [DeleteController::class, 'treatmentCategoriesDelete'])->middleware('scope:treatment_categories:delete');
    Route::delete('/hospital_beds/{id}', [DeleteController::class, 'hospitalBedsDelete'])->middleware('scope:hospital_beds:delete');
    Route::delete('/staff_schedules/{id}', [DeleteController::class, 'staffSchedulesDelete'])->middleware('scope:staff_schedules:delete');
    Route::delete('/logs', [DeleteController::class, 'logsDelete'])->middleware('scope:logs:delete');

    // UPDATE
    Route::put('/doctor/{id}', [UpdateController::class, 'doctorUpdate'])->middleware('scope:doctors:update');
    Route::put('/patient/{id}', [UpdateController::class, 'patientUpdate'])->middleware('scope:patients:update');
    Route::put('/billing/{id}', [UpdateController::class, 'billingUpdate'])->middleware('scope:billing:update');
    Route::put('/appointment/{id}', [UpdateController::class, 'appointmentUpdate'])->middleware('scope:appointments:update');
    Route::put('/staff/{id}', [UpdateController::class, 'staffUpdate'])->middleware('scope:staff:update');
    Route::put('/staff_schedules/{id}', [UpdateController::class, 'staff_scheduleUpdate'])->middleware('scope:staff_schedules:update');
    Route::put('/treatments/{id}', [UpdateController::class, 'treatmentUpdate'])->middleware('scope:treatments:update');
    Route::put('/treatment_categories/{id}', [UpdateController::class, 'treatment_categoriesUpdate'])->middleware('scope:treatment_categories:update');
    Route::put('/hospital_beds/{id}', [UpdateController::class, 'hospital_bedsUpdate'])->middleware('scope:hospital_beds:update');

});
