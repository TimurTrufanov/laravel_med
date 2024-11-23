<?php

namespace App\Services;

use App\Models\DaySheet;

class CalendarService
{
    public function getFilteredDaySheets(?int $doctorId, ?int $clinicId)
    {
        $query = DaySheet::with(['doctor.user', 'clinic']);

        if ($doctorId) {
            $query->where('doctor_id', $doctorId);
        }

        if ($clinicId) {
            $query->where('clinic_id', $clinicId);
        }

        return $query->get();
    }

    public function formatDaySheetsForCalendar($daySheets)
    {
        return $daySheets->map(function ($daySheet) {
            return [
                'id' => $daySheet->id,
                'title' => "{$daySheet->doctor->user->first_name} {$daySheet->doctor->user->last_name} ({$daySheet->clinic->name})",
                'start' => "{$daySheet->date}T{$daySheet->start_time}",
                'end' => "{$daySheet->date}T{$daySheet->end_time}",
                'backgroundColor' => '#28a745',
                'borderColor' => '#28a745',
            ];
        });
    }
}
