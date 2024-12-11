<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailedResource extends JsonResource
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
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'email' => $this->user->email,
            'date_of_birth' => $this->user->date_of_birth,
            'gender' => $this->user->gender,
            'address' => $this->user->address,
            'phone_number' => $this->user->phone_number,
            'appointments' => $this->appointments,
        ];
    }
}
