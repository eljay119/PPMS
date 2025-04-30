<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\OfficeType;
use App\Models\User;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    
    public function index()
    {
        
        $offices = Office::with(['user', 'type'])->get();
        $users = User::all(); 
        $officeTypes = OfficeType::all(); 

    
        return view('admin.offices.index', compact('offices', 'users', 'officeTypes'));
    }

  
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id', 
            'alternate_name' => 'nullable|string|max:255',
            'office_type_id' => 'required|exists:office_types,id' 
        ]);

        
        Office::create([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'alternate_name' => $request->alternate_name,
            'type_id' => $request->office_type_id, 
        ]);

        
        return redirect()->route('admin.offices.index')->with('success', 'Office created successfully.');
    }

    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'type_id' => 'required|exists:office_types,id', 
        ]);

        
        $office = Office::findOrFail($id);

       
        $office->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'type_id' => $request->type_id,
            'alternate_name' => $request->alternate_name,
        ]);

        
        return redirect()->route('admin.offices.index')->with('success', 'Office updated successfully.');
    }

  
    public function destroy($id)
    {
        
        Office::findOrFail($id)->delete();

        
        return redirect()->route('admin.offices.index')->with('success', 'Office deleted successfully.');
    }
}
