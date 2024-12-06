<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaySheetRequest;
use App\Models\Clinic;
use App\Models\DaySheet;
use App\Models\Doctor;
use App\Services\DaySheetService;
use Illuminate\Http\Request;

class DaySheetController extends Controller
{
    /**
     * Display a listing of the resource for admin panel.
     */
    public function index(Request $request, DaySheetService $daySheetService)
    {
        $filters = $request->only('search');
        $daySheets = $daySheetService->getFilteredDaySheets($filters);

        return view('day-sheets.index', compact('daySheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $doctors = Doctor::with('user')->get();
        $clinics = Clinic::all();
        $selectedDoctorId = $request->query('doctor_id');

        return view('day-sheets.create', compact('doctors', 'clinics', 'selectedDoctorId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DaySheetRequest $request, DaySheetService $daySheetService)
    {
        $data = $request->validated();

        try {
            $daySheetService->saveDaySheet($data);
        } catch (\Exception $e) {
            return back()->withErrors(['date' => $e->getMessage()])->withInput();
        }

        return redirect()->route('day-sheets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DaySheet $daySheet)
    {
        $daySheet->load(['doctor.user', 'clinic']);
        return view('day-sheets.show', compact('daySheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DaySheet $daySheet)
    {
        $doctors = Doctor::with('user')->get();
        $clinics = Clinic::all();

        $hasAppointments = $daySheet->timeSheets()->whereHas('appointments')->exists();

        return view('day-sheets.edit', compact('daySheet', 'doctors', 'clinics', 'hasAppointments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DaySheetRequest $request, DaySheet $daySheet, DaySheetService $daySheetService)
    {
        $data = $request->validated();

        try {
            $daySheetService->saveDaySheet($data, $daySheet);
        } catch (\Exception $e) {
            return back()->withErrors(['date' => $e->getMessage()])->withInput();
        }

        return redirect()->route('day-sheets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DaySheet $daySheet, DaySheetService $daySheetService)
    {
        $daySheetService->deleteDaySheet($daySheet);

        return redirect()->route('day-sheets.index');
    }
}
