<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SpecializationResource;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::all();
        return SpecializationResource::collection($specializations);
    }

    public function services($id)
    {
        $specialization = Specialization::with('services')->find($id);

        if (!$specialization) {
            return response()->json(['message' => 'Специализация не найдена'], 404);
        }

        return $specialization->services;
    }
}
