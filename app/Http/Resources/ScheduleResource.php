<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'doctor_name' => $this->doctor->user->first_name . ' ' . $this->doctor->user->last_name,
            'specializations' => $this->doctor->specializations->pluck('name')->toArray(),
            'clinic' => [
                'name' => $this->clinic->name,
                'region' => $this->clinic->region,
                'city' => $this->clinic->city,
                'address' => $this->clinic->address,
                'phone_number' => $this->clinic->phone_number,
                'email' => $this->clinic->email,
            ],
        ];
    }
}
