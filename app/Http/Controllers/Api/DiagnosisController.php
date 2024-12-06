<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    public function getDiagnoses()
    {
        $diagnoses = Diagnosis::all(['id', 'name']);
        return response()->json($diagnoses);
    }
}
