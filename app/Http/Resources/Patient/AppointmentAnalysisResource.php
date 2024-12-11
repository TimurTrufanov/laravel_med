<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentAnalysisResource extends JsonResource
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
            'analysis_name' => $this->analysis->name,
            'appointment_date' => $this->appointment_date->format('Y-m-d'),
            'recommended_date' => $this->recommended_date?->format('Y-m-d'),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'submission_date' => $this->submission_date?->format('Y-m-d'),
            'status' => $this->status,
            'file' => $this->file,
        ];
    }
}
