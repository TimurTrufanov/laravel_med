<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentAppointmentResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'patient' => $this->patient->user->first_name . ' ' . $this->patient->user->last_name,
            'service' => $this->service->name,
            'date' => $this->appointment_date->format('Y-m-d'),
            'status' => $this->status,
            'specialization' => $this->service->specialization->name,
        ];
    }
}
