<?php

namespace App\Http\Controllers\Admin;

use App\Models\PpmpProjectStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PpmpProjectStatusController extends Controller
{
    public function index()
    {
        $statuses = PpmpProjectStatus::latest()->paginate(10); 
        return view('admin.ppmp_project_statuses.index', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|string|max:255|unique:ppmp_project_statuses,status',
            'description' => 'nullable|string|max:500',
        ]);

        PpmpProjectStatus::create([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.ppmp_project_statuses.index')
            ->with('success', 'PPMP Project Status created successfully.');
    }

    public function update(Request $request, PpmpProjectStatus $ppmpProjectStatus)
    {
        $request->validate([
            'status' => 'required|string|max:255|unique:ppmp_project_statuses,status,' . $ppmpProjectStatus->id,
            'description' => 'nullable|string|max:500',
        ]);

        $ppmpProjectStatus->update([
            'status' => $request->status,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.ppmp_project_statuses.index')
            ->with('success', 'PPMP Project Status updated successfully.');
    }

    public function destroy(PpmpProjectStatus $ppmpProjectStatus)
    {
        $ppmpProjectStatus->delete();

        return redirect()->route('admin.ppmp_project_statuses.index')
            ->with('success', 'PPMP Project Status deleted successfully.');
    }
}
