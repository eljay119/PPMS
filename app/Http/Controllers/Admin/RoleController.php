<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function index2()
    {
        return view('admin.roles.index');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'description' => 'required|string',
        ]);

        Role::create($request->all());
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function search(Request $request)
    {
        $search = $request->get('query');

        // Fetch roles based on the search query
        $roles = Role::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return response()->json($roles);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update2(Request $request, string $id)
    {
        //
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $role->update($request->all());
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        'description' => 'nullable|string|max:500',
    ]);

    $role->update([
        'name' => $request->name,
        'description' => $request->description,
    ]);

    return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $role = Role::findOrFail($id);

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    
    }
}
