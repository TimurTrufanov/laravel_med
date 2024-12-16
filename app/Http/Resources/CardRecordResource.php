<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardRecordResource extends JsonResource
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
            'doctor' => $this->doctor->user->first_name . ' ' . $this->doctor->user->last_name,
            'date' => $this->created_at->format('d.m.Y H:i'),
            'medical_history' => $this->medical_history,
            'diagnosis' => $this->diagnosis ? $this->diagnosis->name : $this->custom_diagnosis,
            'treatment' => $this->treatment,
        ];
    }
}
