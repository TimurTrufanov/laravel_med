<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\TimeSheet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function fetchSchedule(Request $request): JsonResponse
    {
        $doctorId = $request->query('doctor_id');
        $clinicId = $request->query('clinic_id');

        $query = TimeSheet::with(['daySheet.doctor.user', 'daySheet.clinic']);

        if ($doctorId) {
            $query->whereHas('daySheet', fn($q) => $q->where('doctor_id', $doctorId));
        }

        if ($clinicId) {
            $query->whereHas('daySheet', fn($q) => $q->where('clinic_id', $clinicId));
        }

        $timeSheets = $query->get();

        $events = $timeSheets->map(function ($timeSheet) {
            return [
                'id' => $timeSheet->id,
                'title' => "{$timeSheet->daySheet->doctor->user->first_name} {$timeSheet->daySheet->doctor->user->last_name}",
                'start' => "{$timeSheet->daySheet->day_of_week}T{$timeSheet->start_time}",
                'end' => "{$timeSheet->daySheet->day_of_week}T{$timeSheet->end_time}",
                'backgroundColor' => '#007bff',
                'borderColor' => '#007bff',
            ];
        });

        return response()->json($events);
    }

    public function index()
    {
        $clinics = Clinic::all();
        $doctors = Doctor::with('user')->get();

        return view('calendar.index', compact('clinics', 'doctors'));
    }
}
