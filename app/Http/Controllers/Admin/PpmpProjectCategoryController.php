<?php

namespace App\Http\Controllers;

use App\Models\PpmpProject;
use App\Models\PpmpProjectCategory;
use App\Models\ModeOfProcurement;
use App\Models\ProjectType;
use Illuminate\Http\Request;

class PpmpProjectController extends Controller
{
    public function index()
    {
        $projects = PpmpProject::with('category', 'mode', 'type')->get();
        return view('ppmp_projects.index', compact('projects'));
    }

    public function show($id)
    {
        $ppmp = PpmpProject::findOrFail($id); 
        $categories = PpmpProjectCategory::all(); // Fetch all categories
        $modes = ModeOfProcurement::all(); // Fetch procurement modes
        $types = ProjectType::all(); // Fetch project types

        return view('ppmp_projects.show', compact('ppmp', 'categories', 'modes', 'types'));
    }

    public function create()
    {
        $categories = PpmpProjectCategory::all();
        $modes = ModeOfProcurement::all();
        $types = ProjectType::all();

        return view('ppmp_projects.create', compact('categories', 'modes', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_id' => 'required|exists:mode_of_procurements,id',
            'type_id' => 'required|exists:type_of_projects,id',
        ]);

        PpmpProject::create($request->all());

        return redirect()->route('ppmp_projects.index')->with('success', 'PPMP Project created successfully.');
    }

    public function edit($id)
    {
        $ppmp = PpmpProject::findOrFail($id);
        $categories = PpmpProjectCategory::all();
        $modes = ModeOfProcurement::all();
        $types = ProjectType::all();

        return view('ppmp_projects.edit', compact('ppmp', 'categories', 'modes', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'category_id' => 'required|exists:ppmp_project_categories,id',
            'mode_id' => 'required|exists:mode_of_procurements,id',
            'type_id' => 'required|exists:type_of_projects,id',
        ]);

        $ppmp = PpmpProject::findOrFail($id);
        $ppmp->update($request->all());

        return redirect()->route('ppmp_projects.index')->with('success', 'PPMP Project updated successfully.');
    }

    public function destroy($id)
    {
        $ppmp = PpmpProject::findOrFail($id);
        $ppmp->delete();

        return redirect()->route('ppmp_projects.index')->with('success', 'PPMP Project deleted successfully.');
    }
}
