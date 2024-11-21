<?php

namespace App\Services;

use App\Models\TimeSheet;

class TimeSheetService
{
    public function hasTimeConflict(int $daySheetId, string $startTime, string $endTime, ?int $excludeId = null): bool
    {
        return TimeSheet::where('day_sheet_id', $daySheetId)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($query) use ($startTime, $endTime) {
                        $query->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->exists();
    }
}
