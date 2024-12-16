<?php

namespace App\Http\Controllers;


use App\Http\Requests\DoctorsWorkloadRequest;
use App\Models\Clinic;
use App\Services\DoctorsWorkloadService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DoctorsWorkloadController extends Controller
{
    public function index(DoctorsWorkloadRequest $request, DoctorsWorkloadService $doctorsWorkloadService)
    {
        $clinics = Clinic::all();
        $filteredData = $doctorsWorkloadService->filterDoctorsData($request);

        $data = $doctorsWorkloadService->getDoctorsWorkloadData($request->validated());

        return view('doctors_workload.index', array_merge(
            ['clinics' => $clinics],
            $filteredData,
            $data
        ));
    }

    public function getFilters(Request $request, DoctorsWorkloadService $doctorsWorkloadService)
    {
        $filteredData = $doctorsWorkloadService->filterDoctorsData($request);

        return response()->json([
            'specializations' => $filteredData['specializations'],
            'doctors' => $filteredData['doctors']->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'first_name' => $doctor->user->first_name,
                    'last_name' => $doctor->user->last_name,
                    'email' => $doctor->user->email,
                ];
            }),
        ]);
    }

    public function downloadPdf(DoctorsWorkloadRequest $request, DoctorsWorkloadService $doctorsWorkloadService)
    {
        $data = $doctorsWorkloadService->getDoctorsWorkloadData($request->validated());

        $pdf = Pdf::loadView('doctors_workload.pdf', array_merge($data, [
            'clinicName' => $data['clinicName'],
            'specializationName' => $data['specializationName'],
        ]));

        return $pdf->download('doctors-workload.pdf');
    }
}
