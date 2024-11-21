<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeSheetRequest;
use App\Models\DaySheet;
use App\Models\TimeSheet;
use App\Services\TimeSheetService;
use Illuminate\Http\Request;

class TimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $timeSheets = TimeSheet::with(['daySheet.doctor.user', 'daySheet.clinic'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('daySheet.doctor.user', function ($query) use ($search) {
                    $query->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('time-sheets.index', compact('timeSheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $daySheets = DaySheet::with('doctor.user')->get();

        return view('time-sheets.create', compact('daySheets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TimeSheetRequest $request, TimeSheetService $timeSheetService)
    {

        $daySheetId = $request->input('day_sheet_id');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        if ($timeSheetService->hasTimeConflict($daySheetId, $startTime, $endTime)) {
            return back()->withErrors(['start_time' => 'Вказаний час перетинається з існуючим записом.'])->withInput();
        }

        TimeSheet::create($request->validated());

        return redirect()->route('time-sheets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TimeSheet $timeSheet)
    {
        return view('time-sheets.show', compact('timeSheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TimeSheet $timeSheet)
    {
        $daySheets = DaySheet::with('doctor.user')->get();

        return view('time-sheets.edit', compact('timeSheet', 'daySheets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TimeSheetRequest $request, TimeSheet $timeSheet, TimeSheetService $timeSheetService)
    {
        $daySheetId = $request->input('day_sheet_id');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        if ($timeSheetService->hasTimeConflict($daySheetId, $startTime, $endTime, $timeSheet->id)) {
            return back()->withErrors(['start_time' => 'Вказаний час перетинається з існуючим записом.'])->withInput();
        }

        $timeSheet->update($request->validated());

        return redirect()->route('time-sheets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TimeSheet $timeSheet)
    {
        $timeSheet->delete();

        return redirect()->route('time-sheets.index');
    }
}
