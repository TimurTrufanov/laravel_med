<?php

namespace App\Http\Controllers\Api\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayScheduleResource;
use App\Http\Resources\DaySheetResource;
use App\Models\DaySheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getSchedule(Request $request)
    {
        $doctor = $request->user()->doctor;
        $schedule = DaySheet::where('doctor_id', $doctor->id)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return DaySheetResource::collection($schedule);
    }

    public function getDayScheduleWithAppointments($dayId)
    {
        try {
            $daySheet = DaySheet::with(['timeSheets.appointments.patient.user', 'timeSheets.appointments.service'])
                ->findOrFail($dayId);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'Розклад не знайдено'], 404);
        }

        $this->authorize('view', $daySheet);

        return DayScheduleResource::make($daySheet)->resolve();
    }
}
