<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentWithRecordsResource extends JsonResource
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
            'appointment_datetime' => $this->appointment_date->format('d.m.Y') . ' ' . $this->timeSheet->start_time . ' - ' . $this->timeSheet->end_time,
            'records' => CardRecordResource::collection($this->cardRecords),
            'analyses' => AppointmentAnalysisResource::collection($this->appointmentAnalyses),
            'services' => AppointmentServiceResource::collection($this->appointmentServices),
        ];
    }
}
