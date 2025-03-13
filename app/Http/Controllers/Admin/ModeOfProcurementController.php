<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModeOfProcurement;
use Illuminate\Http\Request;

class ModeOfProcurementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a listing of Mode of Procurements
    public function index()
    {
        $modes = ModeOfProcurement::all();
        return view('admin.mode_of_procurements.index', compact('modes'));
    }

    // Show the form for creating a new Mode of Procurement
    public function create()
    {
        return view('admin.mode_of_procurements.create');
    }

    // Store a newly created Mode of Procurement
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'conditions' => 'required|string',
            'threshold' => 'required|numeric|min:0',
        ]);

        ModeOfProcurement::create($request->all());

        return redirect()->route('admin.mode_of_procurements.index')->with('success', 'Mode of Procurement created successfully!');
    }

    // Show a specific Mode of Procurement
    public function show(ModeOfProcurement $modeOfProcurement)
    {
        return view('admin.mode_of_procurements.show', compact('modeOfProcurement'));
    }

    // Show the form for editing a Mode of Procurement
    public function edit(ModeOfProcurement $modeOfProcurement)
    {
        return view('admin.mode_of_procurements.edit', compact('modeOfProcurement'));
    }

    // Update a Mode of Procurement
    public function update(Request $request, ModeOfProcurement $modeOfProcurement)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'conditions' => 'required|string',
            'threshold' => 'required|numeric|min:0',
        ]);

        $modeOfProcurement->update($request->all());

        return redirect()->route('admin.mode_of_procurements.index')->with('success', 'Mode of Procurement updated successfully!');
    }

    // Delete a Mode of Procurement
    public function destroy(ModeOfProcurement $modeOfProcurement)
    {
        $modeOfProcurement->delete();
        return redirect()->route('admin.mode_of_procurements.index')->with('success', 'Mode of Procurement deleted successfully!');
    }
}
