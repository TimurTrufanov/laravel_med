<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Jobs\Doctor\SendPasswordMail;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Specialization;
use App\Services\DoctorService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DoctorService $doctorService)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('doctors.index');
        }

        $doctors = $doctorService->getFilteredDoctors($search);

        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clinics = Clinic::all();
        $specializations = Specialization::all();
        return view('doctors.create', compact('clinics', 'specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request, DoctorService $doctorService)
    {
        $data = $request->validated();
        [$doctor, $password] = $doctorService->createDoctor($data);

        SendPasswordMail::dispatch($doctor->user, $password);

        return redirect()->route('doctors.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'clinic', 'specializations', 'daySheets' => function ($query) {
            $query->orderBy('date', 'asc')->orderBy('start_time', 'asc');
        },]);

        return view('doctors.show', compact('doctor'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctor $doctor)
    {
        $clinics = Clinic::all();
        $specializations = Specialization::all();
        $selectedSpecializations = $doctor->specializations()->pluck('specializations.id')->toArray();

        return view('doctors.edit', compact('doctor', 'clinics', 'specializations', 'selectedSpecializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, Doctor $doctor, DoctorService $doctorService)
    {
        $data = $request->validated();

        $doctorService->updateDoctor($doctor, $data);

        return redirect()->route('doctors.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor, DoctorService $doctorService)
    {
        $doctorService->deleteDoctor($doctor);

        return redirect()->route('doctors.index');
    }
}
