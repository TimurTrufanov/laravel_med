<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardRecordResource extends JsonResource
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
            'id' => $this->id,
            'date' => $this->created_at->format('d.m.Y H:i'),
            'medical_history' => $this->medical_history,
            'diagnosis' => $this->diagnosis?->name ?? $this->custom_diagnosis,
            'treatment' => $this->treatment,
            'doctor' => [
                'first_name' => $this->doctor->user->first_name,
                'last_name' => $this->doctor->user->last_name,
            ],
        ];
    }
}
