<?php

namespace App\Services;

use App\Models\DaySheet;
use Exception;

class DaySheetService
{
    /**
     * @throws Exception
     */
    public function createDaySheets(array $doctorIds, string $clinicId, array $daysOfWeek): array
    {
        $createdDaySheets = [];

        foreach ($doctorIds as $doctorId) {
            foreach ($daysOfWeek as $day) {
                $existingDaySheet = DaySheet::where('doctor_id', $doctorId)
                    ->where('clinic_id', $clinicId)
                    ->where('day_of_week', $day)
                    ->first();

                if ($existingDaySheet) {
                    throw new Exception("Розклад для лікаря на {$day} вже існує.");
                }

                $createdDaySheets[] = DaySheet::create([
                    'doctor_id' => $doctorId,
                    'clinic_id' => $clinicId,
                    'day_of_week' => $day,
                ]);
            }
        }

        return $createdDaySheets;
    }
}
