<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecializationRequest;
use App\Models\Specialization;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('specializations.index');
        }

        $query = Specialization::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $specializations = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('specializations.index', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SpecializationRequest $request)
    {
        Specialization::create($request->validated());
        return redirect()->route('specializations.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Specialization $specialization)
    {
        return view('specializations.show', compact('specialization'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Specialization $specialization)
    {
        return view('specializations.edit', compact('specialization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        $specialization->update($request->validated());
        return redirect()->route('specializations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
        return redirect()->route('specializations.index');
    }
}
