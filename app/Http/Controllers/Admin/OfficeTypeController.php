<?php

namespace App\Http\Controllers\Admin;

use App\Models\OfficeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfficeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officeTypes = OfficeType::latest()->paginate(10); // Added pagination for better performance
        return view('admin.officeTypes.index', compact('officeTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.officeTypes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:office_types,type',
        ]);

        OfficeType::create(['type' => $request->type]);

        return redirect()->route('admin.officeTypes.index')
            ->with('success', 'Office Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeType $officeType)
    {
        return view('admin.officeTypes.show', compact('officeType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficeType $officeType)
    {
        return view('admin.officeTypes.edit', compact('officeType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OfficeType $officeType)
    {
        $request->validate([
            'type' => 'required|string|max:255|unique:office_types,type,' . $officeType->id,
        ]);

        $officeType->update(['type' => $request->type]);

        return redirect()->route('admin.officeTypes.index')
            ->with('success', 'Office Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeType $officeType)
    {
        $officeType->delete();

        return redirect()->route('admin.officeTypes.index')
            ->with('success', 'Office Type deleted successfully.');
    }
}
