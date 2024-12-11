<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicResource extends JsonResource
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
            'name' => $this->name,
            'region' => $this->region,
            'city' => $this->city,
            'address' => $this->address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'specializations' => SpecializationResource::collection($this->specializations),
        ];
    }
}
