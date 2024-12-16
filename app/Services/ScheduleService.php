<?php

namespace App\Services;

use App\Models\DaySheet;
use Carbon\Carbon;

class ScheduleService
{
    public function getAvailableSchedule($filters)
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

        $this->applyFilters($query, $filters);

        return $query->orderBy('day_sheets.date', 'asc')
            ->orderBy('day_sheets.start_time', 'asc')
            ->get();
    }

    public function getDayScheduleForPatient($dayId)
    {
        $daySheet = DaySheet::with(['timeSheets'])
            ->whereHas('timeSheets', function ($query) {
                $query->where('is_active', true);
            })
            ->find($dayId);

        if (!$daySheet) {
            return null;
        }

        $currentDate = now()->toDateString();
        $currentTime = now()->format('H:i');

        $isToday = $daySheet->date === $currentDate;

        $filteredTimeSheets = $this->filterTimeSheets($daySheet->timeSheets, $isToday, $currentTime);

        return [
            'date' => $daySheet->formatted_date,
            'time_sheets' => $filteredTimeSheets,
        ];
    }

    private function applyFilters($query, $filters)
    {
        if (isset($filters['clinic'])) {
            $query->where('day_sheets.clinic_id', $filters['clinic']);
        }

        if (isset($filters['specialization'])) {
            $query->whereHas('doctor.specializations', function ($query) use ($filters) {
                $query->where('specializations.id', $filters['specialization']);
            });
        }

        if (isset($filters['service'])) {
            $query->whereHas('doctor.specializations.services', function ($query) use ($filters) {
                $query->where('services.id', $filters['service']);
            });
        }
    }

    private function filterTimeSheets($timeSheets, $isToday, $currentTime)
    {
        return $timeSheets->filter(function ($timeSheet) use ($isToday, $currentTime) {
            if ($isToday) {
                return Carbon::createFromFormat('H:i', $timeSheet->start_time)->gte(Carbon::createFromFormat('H:i', $currentTime));
            }
            return true;
        });
    }
}
