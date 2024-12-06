<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doctor\DayScheduleResource;
use App\Models\DaySheet;
use App\Services\ScheduleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function getSchedule(Request $request)
    {
        $doctor = $request->user()->doctor;
        $schedule = $this->scheduleService->getDoctorSchedule($doctor->id);

        return response()->json($schedule, 200);
    }

    public function getAvailableSchedule(Request $request)
    {
        $query = DaySheet::with(['timeSheets', 'doctor.user', 'doctor.specializations', 'clinic'])
            ->whereHas('timeSheets', function ($query) {
                $query->where('is_active', true);
            })
            ->where(function ($query) {
                $query->where('date', '>', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->where('date', now()->toDateString())
                            ->where('end_time', '>', now()->format('H:i'));
                    });
            });

        if ($request->filled('clinic')) {
            $query->where('day_sheets.clinic_id', $request->clinic);
        }

        if ($request->filled('specialization')) {
            $query->whereHas('doctor.specializations', function ($query) use ($request) {
                $query->where('specializations.id', $request->specialization);
            });
        }

        if ($request->filled('service')) {
            $query->whereHas('doctor.specializations.services', function ($query) use ($request) {
                $query->where('services.id', $request->service);
            });
        }

        $schedules = $query->orderBy('day_sheets.date', 'asc')
            ->orderBy('day_sheets.start_time', 'asc')
            ->get()
            ->map(function ($daySheet) {
                return [
                    'id' => $daySheet->id,
                    'date' => $daySheet->formatted_date,
                    'start_time' => $daySheet->start_time,
                    'end_time' => $daySheet->end_time,
                    'doctor_name' => $daySheet->doctor->user->first_name . ' ' . $daySheet->doctor->user->last_name,
                    'specializations' => $daySheet->doctor->specializations->pluck('name')->toArray(),
                    'clinic' => [
                        'name' => $daySheet->clinic->name,
                        'region' => $daySheet->clinic->region,
                        'city' => $daySheet->clinic->city,
                        'address' => $daySheet->clinic->address,
                        'phone_number' => $daySheet->clinic->phone_number,
                        'email' => $daySheet->clinic->email,
                    ],
                ];
            });

        return response()->json($schedules, 200);
    }

    public function getDayScheduleForPatient($dayId)
    {
        $daySheet = DaySheet::with(['timeSheets'])
            ->whereHas('timeSheets', function ($query) {
                $query->where('is_active', true);
            })
            ->find($dayId);

        if (!$daySheet) {
            return response()->json(['message' => 'Розклад не знайдено'], 404);
        }

        $currentDate = now()->toDateString();
        $currentTime = now()->format('H:i');

        $isToday = $daySheet->date === $currentDate;

        return response()->json([
            'date' => $daySheet->formatted_date,
            'time_sheets' => $daySheet->timeSheets->filter(function ($timeSheet) use ($isToday, $currentTime) {
                if ($isToday) {
                    return Carbon::createFromFormat('H:i', $timeSheet->start_time)->gte(Carbon::createFromFormat('H:i', $currentTime));
                }
                return true;
            })->map(function ($timeSheet) {
                return [
                    'id' => $timeSheet->id,
                    'start_time' => $timeSheet->start_time,
                    'end_time' => $timeSheet->end_time,
                    'is_active' => $timeSheet->is_active,
                ];
            })->values(),
        ]);
    }

    public function getDayScheduleWithAppointments($dayId)
    {
        $doctor = request()->user()->doctor;

        $daySheet = DaySheet::with(['timeSheets.appointments.patient.user', 'timeSheets.appointments.service'])
            ->where('doctor_id', $doctor->id)
            ->find($dayId);

        if (!$daySheet) {
            return response()->json(['message' => 'Розклад не знайдено'], 404);
        }

        return new DayScheduleResource($daySheet);
    }
}
