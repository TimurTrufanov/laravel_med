<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function fetchSchedule(Request $request, CalendarService $calendarService): JsonResponse
    {
        $doctorId = $request->query('doctor_id');
        $clinicId = $request->query('clinic_id');

        $daySheets = $calendarService->getFilteredDaySheets($doctorId, $clinicId);
        $events = $calendarService->formatDaySheetsForCalendar($daySheets);

        return response()->json($events);
    }

    public function index()
    {
        $clinics = Clinic::all();
        $doctors = Doctor::with('user')->get();

        return view('calendar.index', compact('clinics', 'doctors'));
    }
}
