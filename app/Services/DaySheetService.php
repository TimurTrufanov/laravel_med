<?php

namespace App\Services;

use App\Models\DaySheet;
use App\Models\Doctor;
use App\Models\TimeSheet;

class DaySheetService
{
    public function getFilteredDaySheets(array $filters)
    {
        $query = DaySheet::with(['doctor.user', 'clinic']);

        if (!empty($filters['search'])) {
            $query->whereHas('doctor.user', function ($q) use ($filters) {
                $q->where('first_name', 'like', "%{$filters['search']}%")
                    ->orWhere('last_name', 'like', "%{$filters['search']}%");
            })->orWhereHas('clinic', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function saveDaySheet(array $data, ?DaySheet $daySheet = null): void
    {
        $daySheet = $daySheet ?? new DaySheet();

        $doctor = Doctor::findOrFail($data['doctor_id']);
        $data['clinic_id'] = $doctor->clinic_id;

        $daySheet->fill($data);
        $daySheet->save();

        $this->generateTimeSheets($daySheet);
    }


    public function deleteDaySheet(DaySheet $daySheet): void
    {
        $daySheet->timeSheets()->delete();
        $daySheet->delete();
    }

    private function generateTimeSheets(DaySheet $daySheet): void
    {
        $appointmentDuration = $daySheet->doctor->appointment_duration;
        $startTime = strtotime($daySheet->start_time);
        $endTime = strtotime($daySheet->end_time);

        $breaks = [
            ['start' => '12:00', 'end' => '13:00'],
            ['start' => '17:00', 'end' => '18:00'],
        ];

        TimeSheet::where('day_sheet_id', $daySheet->id)->delete();

        while ($startTime < $endTime) {
            $currentTime = date('H:i', $startTime);

            foreach ($breaks as $break) {
                if ($currentTime >= $break['start'] && $currentTime < $break['end']) {
                    $startTime = strtotime($break['end']);
                    continue 2;
                }
            }

            $nextTime = date('H:i', strtotime("+{$appointmentDuration} minutes", $startTime));

            if (strtotime($nextTime) > $endTime) {
                break;
            }

            TimeSheet::create([
                'day_sheet_id' => $daySheet->id,
                'start_time' => $currentTime,
                'end_time' => $nextTime,
            ]);

            $startTime = strtotime("+{$appointmentDuration} minutes", $startTime);
        }
    }
}
