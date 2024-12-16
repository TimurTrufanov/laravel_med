<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\ScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Http\Resources\TimeSheetResource;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function getAvailableSchedule(ScheduleRequest $request, ScheduleService $scheduleService)
    {
        $filters = $request->validated();
        $schedules = $scheduleService->getAvailableSchedule($filters);

        return ScheduleResource::collection($schedules)->resolve();
    }

    public function getDayScheduleForPatient($dayId, ScheduleService $scheduleService)
    {
        $scheduleData = $scheduleService->getDayScheduleForPatient($dayId);

        if (!$scheduleData) {
            return response()->json(['message' => 'Розклад не знайдено'], 404);
        }

        return response()->json([
            'date' => $scheduleData['date'],
            'time_sheets' => TimeSheetResource::collection($scheduleData['time_sheets']),
        ]);
    }
}
