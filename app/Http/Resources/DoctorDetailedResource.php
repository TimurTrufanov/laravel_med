<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorDetailedResource extends JsonResource
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
            'full_name' => $this->user->first_name . ' ' . $this->user->last_name,
            'email' => $this->user->email,
            'date_of_birth' => $this->user->date_of_birth,
            'address' => $this->user->address,
            'phone_number' => $this->user->phone_number,
            'photo' => $this->user->photo,
            'clinic' => $this->clinic->name,
            'specializations' => $this->specializations->pluck('name'),
            'position' => $this->position,
            'bio' => $this->bio,
        ];
    }
}
