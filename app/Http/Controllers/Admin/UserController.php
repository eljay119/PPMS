<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function index()
    {
        // Fetch all users
        $users = User::with('role')->get();
        $roles = Role::all();
        return view('admin.users.index', compact('users','roles'));
    }

     /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role' => 'required|exists:roles,id',
            ], 
            [
                'name.required' => 'Please provide your name.',
                'email.required' => 'Please provide your email.',
                'username.required'=> 'Please provide your username',
                'role.required' => 'Please provide role',
                'active' => 'nullable|boolean',
            ]);
                        
            $data = User::create([
                
                'name' => $request->name,
                'email' => $request->email,
                'password' => 'bisucandijay',
                'username' => $request->username,
                'role_id' => $request->role,
                'active' => $request->active ?? 1,
            ]);

            error_log('Created Data: ' . print_r($data->toArray(), true));

            Log::info('Data created:', $data->toArray());

            return redirect()->route('admin.users.index');
        
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|max:255',
            'role' => 'required|exists:roles,id',
        ]);


        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role_id = $request->role;
        $user->active = $request->active ?? 1;

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Find the user and delete them
        $user = User::findOrFail($id);
        $user->delete();
        
        // Redirect with a success message
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
