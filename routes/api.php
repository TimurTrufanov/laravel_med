<?php

use App\Http\Controllers\Api\AnalysisController;
use App\Http\Controllers\Api\CardController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\DiagnosisController;
use App\Http\Controllers\Api\Doctor\AuthController as DoctorAuthController;
use App\Http\Controllers\Api\Patient\AuthController as PatientAuthController;
use App\Http\Controllers\Api\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Api\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SpecializationController;
use App\Http\Controllers\CalendarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//admin
Route::get('calendar', [CalendarController::class, 'fetchSchedule']);

//doctor
Route::prefix('doctor')->group(function () {
    Route::post('/login', [DoctorAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/details', [DoctorAuthController::class, 'getDetails']);
        Route::get('/schedule', [ScheduleController::class, 'getSchedule']);
        Route::get('/schedule/{day}', [ScheduleController::class, 'getDayScheduleWithAppointments']);
        Route::get('/diagnoses', [DiagnosisController::class, 'getDiagnoses']);
        Route::get('/analyses', [AnalysisController::class, 'getAnalyses']);
        Route::get('/services', [ServiceController::class, 'getServices']);
        Route::post('/appointments/{appointmentId}/details', [DoctorAppointmentController::class, 'addAppointmentDetails']);
        Route::get('/appointments/{appointmentId}/details', [DoctorAppointmentController::class, 'getAppointmentDetails']);
        Route::post('/logout', [DoctorAuthController::class, 'logout']);
    });
});

//patient
Route::prefix('patient')->group(function () {
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::post('/register', [PatientAuthController::class, 'register']);
    Route::get('/schedule', [ScheduleController::class, 'getAvailableSchedule']);
    Route::get('/schedule/{day}', [ScheduleController::class, 'getDayScheduleForPatient']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/details', [PatientAuthController::class, 'getDetails']);
        Route::post('/appointments', [PatientAppointmentController::class, 'createAppointment']);
        Route::post('/logout', [PatientAuthController::class, 'logout']);
    });
});

Route::get('/clinics', [ClinicController::class, 'index']);

Route::get('/specializations', [SpecializationController::class, 'index']);
Route::get('/specializations/{id}/services', [SpecializationController::class, 'services']);
