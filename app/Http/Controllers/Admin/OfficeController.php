<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\User;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    // Display the list of offices with associated data
    public function index()
    {
        // Fetch offices with their related user and type
        $offices = Office::with(['user', 'type'])->get();
        $users = User::all(); // Fetch all users for dropdown
        $officeTypes = OfficeType::all(); // Fetch all office types for dropdown

        // Pass data to the view
        return view('admin.offices.index', compact('offices', 'users', 'officeTypes'));
    }

    // Store a new office in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', // Ensure user exists
            'alternate_name' => 'nullable|string|max:255',
            'type_id' => 'required|exists:office_types,id' // Ensure type exists
        ]);

        // Create the office record
        Office::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'alternate_name' => $request->alternate_name,
            'head_name' => $request->head_name, // Ensure head_name is explicitly set to NULL
            'type_id' => $request->type_id, // Fixed here
        ]);

        // Redirect back with success message
        return redirect()->route('admin.offices.index')->with('success', 'Office created successfully.');
    }

    // Update an existing office
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'type_id' => 'required|exists:office_types,id', // Fixed here
        ]);

        // Find the office or fail
        $office = Office::findOrFail($id);

        // Update the office record
        $office->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'type_id' => $request->type_id, // Fixed here
            'alternate_name' => $request->alternate_name,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.offices.index')->with('success', 'Office updated successfully.');
    }

    // Delete an office
    public function destroy($id)
    {
        // Find and delete the office
        Office::findOrFail($id)->delete();

        // Redirect back with success message
        return redirect()->route('admin.offices.index')->with('success', 'Office deleted successfully.');
    }
}
