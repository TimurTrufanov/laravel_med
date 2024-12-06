<?php

namespace App\Services;

use App\Models\DaySheet;
use Illuminate\Support\Collection;

class ScheduleService
{
    public function getDoctorSchedule(int $doctorId): Collection
    {
        return DaySheet::where('doctor_id', $doctorId)
            ->orderBy('date', 'asc')
            ->get()
            ->map(function ($daySheet) {
                return [
                    'id' => $daySheet->id,
                    'date' => $daySheet->formatted_date,
                    'start_time' => $daySheet->start_time,
                    'end_time' => $daySheet->end_time,
                    'appointment_count' => $daySheet->timeSheets->sum(function ($timeSheet) {
                        return $timeSheet->appointments->count();
                    }),
                ];
            });
    }

    public function getDaySheetForDoctor(int $doctorId, int $dayId)
    {
        return DaySheet::with(['timeSheets'])
            ->where('doctor_id', $doctorId)
            ->find($dayId);
    }

    public function formatDaySheet(DaySheet $daySheet): array
    {
        return [
            'date' => $daySheet->formatted_date,
            'time_sheets' => $daySheet->timeSheets->map(function ($timeSheet) {
                return [
                    'id' => $timeSheet->id,
                    'start_time' => $timeSheet->start_time,
                    'end_time' => $timeSheet->end_time,
                    'is_active' => $timeSheet->is_active,
                ];
            }),
        ];
    }
}
