<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projectTypes = ProjectType::all();
        return view('project_types.index', compact('projectTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        ProjectType::create($request->all());

        return redirect()->route('project_types.index')
            ->with('success', 'Project Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectType $projectType)
    {
        return view('project_types.show', compact('projectType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectType $projectType)
    {
        return view('project_types.edit', compact('projectType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectType $projectType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $projectType->update($request->all());

        return redirect()->route('project_types.index')
            ->with('success', 'Project Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectType $projectType)
    {
        $projectType->delete();

        return redirect()->route('project_types.index')
            ->with('success', 'Project Type deleted successfully.');
    }
}
