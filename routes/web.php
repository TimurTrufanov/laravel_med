<?php

use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\DaySheetController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\DiseaseStatisticsController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorsWorkloadController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SpecializationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', IndexController::class)->name('main.index');
    Route::resource('diagnoses', DiagnosisController::class);
    Route::resource('clinics', ClinicController::class);
    Route::resource('specializations', SpecializationController::class);
    Route::resource('analyses', AnalysisController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('day-sheets', DaySheetController::class);

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('get-specializations-by-clinic', [DoctorController::class, 'getSpecializationsByClinic'])->name('doctors.getSpecializationsByClinic');

    Route::get('/disease-statistics', [DiseaseStatisticsController::class, 'index'])->name('disease_statistics.index');
    Route::post('/disease-statistics/download-pdf', [DiseaseStatisticsController::class, 'downloadPdf'])->name('disease_statistics.pdf');
    Route::get('/doctors-workload', [DoctorsWorkloadController::class, 'index'])->name('doctors_workload.index');
    Route::get('/doctors-workload/filters', [DoctorsWorkloadController::class, 'getFilters'])->name('doctors_workload.filters');
    Route::post('/doctors-workload/download-pdf', [DoctorsWorkloadController::class, 'downloadPdf'])->name('doctors_workload.pdf');
    Route::get('/financial-report', [FinancialReportController::class, 'index'])->name('financial_report.index');
    Route::post('/financial-report/download-pdf', [FinancialReportController::class, 'downloadPdf'])->name('financial_report.pdf');
});

