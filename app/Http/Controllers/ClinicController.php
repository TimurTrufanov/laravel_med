<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClinicRequest;
use App\Models\Clinic;
use App\Models\Specialization;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('clinics.index');
        }

        $query = Clinic::with('specializations');

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $clinics = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('clinics.index', compact('clinics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specialization::all();
        return view('clinics.create', compact('specializations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request)
    {
        $clinic = Clinic::create($request->validated());
        $clinic->specializations()->sync($request->input('specializations', []));
        return redirect()->route('clinics.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Clinic $clinic)
    {
        $clinic->load('specializations');
        return view('clinics.show', compact('clinic'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clinic $clinic)
    {
        $specializations = Specialization::all();
        $selectedSpecializations = $clinic->specializations()->pluck('specializations.id')->toArray();
        return view('clinics.edit', compact('clinic', 'specializations', 'selectedSpecializations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicRequest $request, Clinic $clinic)
    {
        $clinic->update($request->validated());
        $clinic->specializations()->sync($request->input('specializations', []));
        return redirect()->route('clinics.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clinic $clinic)
    {
        $clinic->delete();
        return redirect()->route('clinics.index');
    }
}
