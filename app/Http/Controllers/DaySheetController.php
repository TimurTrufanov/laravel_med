<?php

namespace App\Http\Controllers;

use App\Http\Requests\DaySheet\StoreRequest;
use App\Http\Requests\DaySheet\UpdateRequest;
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
    public function index(Request $request)
    {
        $query = DaySheet::with(['doctor.user', 'clinic']);

        if ($search = $request->query('search')) {
            $query->whereHas('doctor.user', function ($query) use ($search) {
                $query->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%");
            })->orWhereHas('clinic', function ($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            });
        }

        $daySheets = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('day-sheets.index', compact('daySheets'));
    }

    /**
     * API method for FullCalendar.
     */
    public function apiIndex(Request $request)
    {
        $query = DaySheet::with(['doctor.user', 'clinic']);

        if ($doctorId = $request->query('doctor_id')) {
            $query->where('doctor_id', $doctorId);
        }

        $daySheets = $query->get();

        $events = $daySheets->map(function ($daySheet) {
            return [
                'id' => $daySheet->id,
                'title' => "{$daySheet->doctor->user->first_name} {$daySheet->doctor->user->last_name}",
                'start' => now()->startOfWeek()->addDays(array_search($daySheet->day_of_week, [
                    'Понеділок', 'Вівторок', 'Середа', 'Четвер', 'Пʼятниця', 'Субота', 'Неділя'
                ]))->format('Y-m-d'),
                'allDay' => true,
                'backgroundColor' => '#007bff',
                'borderColor' => '#007bff',
            ];
        });

        return response()->json($events);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::with('user')->get();
        $clinics = Clinic::all();

        return view('day-sheets.create', compact('doctors', 'clinics'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request, DaySheetService $daySheetService)
    {
        $validated = $request->validated();

        try {
            $createdDaySheets = $daySheetService->createDaySheets(
                $validated['doctor_ids'],
                $validated['clinic_id'],
                $validated['days_of_week']
            );
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['days_of_week' => $e->getMessage()])
                ->withInput();
        }

        if ($request->wantsJson()) {
            return response()->json($createdDaySheets, 201);
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

        return view('day-sheets.edit', compact('daySheet', 'doctors', 'clinics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, DaySheet $daySheet)
    {
        $data = $request->validated();
        $daySheet->update($data);

        if ($request->wantsJson()) {
            return response()->json($daySheet);
        }

        return redirect()->route('day-sheets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, DaySheet $daySheet)
    {
        $daySheet->delete();

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect()->route('day-sheets.index');
    }
}
