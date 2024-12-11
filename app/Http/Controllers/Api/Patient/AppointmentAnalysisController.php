<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Patient\UploadAnalysisFileRequest;
use App\Http\Resources\Patient\AppointmentAnalysisResource;
use App\Models\AppointmentAnalysis;
use Illuminate\Http\Request;

class AppointmentAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $analyses = $request->user()->patient->appointmentAnalyses()
            ->with('analysis')
            ->orderByRaw("IF(appointment_analyses.status = 'завершений', 1, 0)")
            ->orderBy('created_at', 'desc')
            ->get();

        return AppointmentAnalysisResource::collection($analyses)->resolve();
    }

    public function uploadResult(UploadAnalysisFileRequest $request, $analysisId)
    {
        $analysis = AppointmentAnalysis::findOrFail($analysisId);

        $filePath = $request->file('file')->store('analyses/results', 'public');

        $analysis->update([
            'file' => $filePath,
            'submission_date' => now(),
            'status' => 'завершений',
        ]);

        return response()->json(['file' => $filePath]);
    }
}
