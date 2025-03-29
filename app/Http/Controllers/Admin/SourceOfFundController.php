<?php

namespace App\Http\Controllers\Admin;

use App\Models\SourceOfFund;
use App\Models\PpmpProjectCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceOfFundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sourceOfFunds = SourceOfFund::latest()->paginate(10); // Added pagination
        return view('admin.source_of_funds.index', compact('sourceOfFunds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.source_of_funds.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:source_of_funds,name',
            'description' => 'nullable|string|max:500',
        ]);

        SourceOfFund::create($request->only(['name', 'description']));

        return redirect()->route('admin.source_of_funds.index')
            ->with('success', 'Source of Fund created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SourceOfFund $sourceOfFund)
    {
        return view('admin.source_of_funds.show', compact('sourceOfFund'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SourceOfFund $sourceOfFund)
    {
        return view('admin.source_of_funds.edit', compact('sourceOfFund'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SourceOfFund $sourceOfFund)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:source_of_funds,name,' . $sourceOfFund->id,
            'description' => 'nullable|string|max:500',
        ]);

        $sourceOfFund->update($request->only(['name', 'description']));

        return redirect()->route('admin.source_of_funds.index')
            ->with('success', 'Source of Fund updated successfully.');
    }

    
    public function destroy(SourceOfFund $sourceOfFund)
    {
        $sourceOfFund->delete();

        return redirect()->route('admin.source_of_funds.index')
            ->with('success', 'Source of Fund deleted successfully.');
    }

    public function consolidate($id)
    {
        $categories = PpmpProjectCategory::all();

        $sources = SourceOfFund::all();

        return view('bacsec.app.consolidate', compact('categories', 'sources'));
    }
}
