<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalysisRequest;
use App\Models\Analysis;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($request->has('search') && $search === null) {
            return redirect()->route('analyses.index');
        }

        $query = Analysis::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $analyses = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('analyses.index', compact('analyses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('analyses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnalysisRequest $request)
    {
        Analysis::create($request->validated());
        return redirect()->route('analyses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Analysis $analysis)
    {
        return view('analyses.show', compact('analysis'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Analysis $analysis)
    {
        return view('analyses.edit', compact('analysis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnalysisRequest $request, Analysis $analysis)
    {
        $analysis->update($request->validated());
        return redirect()->route('analyses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Analysis $analysis)
    {
        $analysis->delete();
        return redirect()->route('analyses.index');
    }
}
