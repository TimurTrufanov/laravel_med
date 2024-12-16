<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiseaseStatisticsRequest;
use App\Models\Clinic;
use App\Models\Diagnosis;
use App\Services\DiseaseStatisticsService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DiseaseStatisticsController extends Controller
{
    public function index(DiseaseStatisticsRequest $request, DiseaseStatisticsService $diseaseStatisticsService)
    {
        $clinics = Clinic::all();
        $diagnoses = Diagnosis::all();

        $data = $diseaseStatisticsService->getDiseaseStatisticsData($request->validated());

        return view('disease_statistics.index', array_merge(
            ['clinics' => $clinics, 'diagnoses' => $diagnoses],
            $data
        ));
    }

    public function downloadPdf(DiseaseStatisticsRequest $request, DiseaseStatisticsService $diseaseStatisticsService)
    {
        $data = $diseaseStatisticsService->getDiseaseStatisticsData($request->validated());

        $pdf = Pdf::loadView('disease_statistics.pdf', $data);

        return $pdf->download('disease-statistics.pdf');
    }
}
