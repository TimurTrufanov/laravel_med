<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialReportRequest;
use App\Models\Clinic;
use App\Services\FinancialReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(FinancialReportRequest $request, FinancialReportService $financialReportService)
    {
        $clinics = Clinic::all();

        $data = $financialReportService->generateReport($request->validated());

        return view('financial_report.index', array_merge(
            ['clinics' => $clinics],
            $data
        ));
    }

    public function downloadPdf(FinancialReportRequest $request, FinancialReportService $financialReportService)
    {
        $data = $financialReportService->generateReport($request->validated());

        $pdf = Pdf::loadView('financial_report.pdf', $data);

        return $pdf->download('financial-report.pdf');
    }
}
