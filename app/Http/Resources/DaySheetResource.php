<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DaySheetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->formatted_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'appointment_count' => $this->timeSheets->sum(function ($timeSheet) {
                return $timeSheet->appointments->count();
            }),
        ];
    }
}
