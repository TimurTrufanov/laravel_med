<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DayScheduleResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date' => $this->formatted_date,
            'time_sheets' => $this->timeSheets->map(function ($timeSheet) {
                return [
                    'id' => $timeSheet->id,
                    'start_time' => $timeSheet->start_time,
                    'end_time' => $timeSheet->end_time,
                    'is_active' => $timeSheet->is_active,
                    'appointment' => $timeSheet->appointments->map(function ($appointment) {
                        return [
                            'id' => $appointment->id,
                            'patient_name' => $appointment->patient->user->first_name . ' ' . $appointment->patient->user->last_name,
                            'service_name' => $appointment->service->name,
                            'specialization_id' => $appointment->service->specialization->id,
                            'appointment_date' => $appointment->appointment_date,
                            'patient_id' => $appointment->patient_id,
                        ];
                    })->first(),
                ];
            }),
        ];
    }
}
