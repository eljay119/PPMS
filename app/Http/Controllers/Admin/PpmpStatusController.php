<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PPMPStatus;

class PPMPStatusController extends Controller
{
    public function index()
    {
        $statuses = PPMPStatus::all();
        return view('admin.ppmp_status.index', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        PPMPStatus::create($request->only('name'));
        return redirect()->route('admin.ppmp_status.index')->with('success', 'Status added successfully.');
    }

    public function update(Request $request, PPMPStatus $ppmp_status)
    {
        $request->validate(['name' => 'required']);
        $ppmp_status->update($request->only('name'));
        return redirect()->route('admin.ppmp_status.index')->with('success', 'Status updated successfully.');
    }

    public function destroy(PPMPStatus $ppmp_status)
    {
        $ppmp_status->delete();
        return redirect()->route('admin.ppmp_status.index')->with('success', 'Status deleted successfully.');
    }
}
