<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiagnosisRequest;
use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('diagnoses.index');
        }

        $query = Diagnosis::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $diagnoses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('diagnoses.index', compact('diagnoses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diagnoses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiagnosisRequest $request)
    {
        Diagnosis::create($request->validated());
        return redirect()->route('diagnoses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diagnosis $diagnosis)
    {
        return view('diagnoses.show', compact('diagnosis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diagnosis $diagnosis)
    {
        return view('diagnoses.edit', compact('diagnosis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiagnosisRequest $request, Diagnosis $diagnosis)
    {
        $diagnosis->update($request->validated());
        return redirect()->route('diagnoses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diagnosis $diagnosis)
    {
        $diagnosis->delete();
        return redirect()->route('diagnoses.index');
    }
}
