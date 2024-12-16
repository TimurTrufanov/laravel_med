<?php

use App\Http\Controllers\Api\AnalysisController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\DiagnosisController;
use App\Http\Controllers\Api\Doctor\AuthController as DoctorAuthController;
use App\Http\Controllers\Api\Patient\AppointmentAnalysisController;
use App\Http\Controllers\Api\Patient\AuthController as PatientAuthController;
use App\Http\Controllers\Api\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Api\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Api\Doctor\ScheduleController as DoctorScheduleController;
use App\Http\Controllers\Api\Patient\CardController;
use App\Http\Controllers\Api\Patient\ScheduleController as PatientScheduleController;
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
    Route::middleware(['auth:sanctum', 'doctor'])->group(function () {
        Route::get('/details', [DoctorAuthController::class, 'getDetails']);
        Route::get('/schedule', [DoctorScheduleController::class, 'getSchedule']);
        Route::get('/schedule/{day}', [DoctorScheduleController::class, 'getDayScheduleWithAppointments']);
        Route::post('/appointments/{appointmentId}/details', [DoctorAppointmentController::class, 'addDetails']);
        Route::get('/appointments/{appointmentId}/details', [DoctorAppointmentController::class, 'getDetails']);
        Route::patch('/appointments/{appointmentId}/status', [DoctorAppointmentController::class, 'updateStatus']);
        Route::post('/logout', [DoctorAuthController::class, 'logout']);
    });
});

//patient
Route::prefix('patient')->group(function () {
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::post('/register', [PatientAuthController::class, 'register']);
    Route::get('/schedule', [PatientScheduleController::class, 'getAvailableSchedule']);
    Route::get('/schedule/{day}', [PatientScheduleController::class, 'getDayScheduleForPatient']);
    Route::middleware(['auth:sanctum', 'patient'])->group(function () {
        Route::post('/appointments', [PatientAppointmentController::class, 'createAppointment']);
        Route::get('/analyses', [AppointmentAnalysisController::class, 'index']);
        Route::get('/card-records', [CardController::class, 'index']);
        Route::get('/card-records/specializations', [CardController::class, 'getSpecializations']);
        Route::post('/analyses/{id}/upload', [AppointmentAnalysisController::class, 'uploadResult']);
        Route::post('/logout', [PatientAuthController::class, 'logout']);
    });
});

Route::get('/clinics', [ClinicController::class, 'index']);
Route::get('/diagnoses', [DiagnosisController::class, 'index']);
Route::get('/analyses', [AnalysisController::class, 'index']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/specializations', [SpecializationController::class, 'index']);
Route::get('/specializations/{id}/services', [SpecializationController::class, 'services']);
