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
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|exists:roles,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048', // Validate image file
        ], 
        [
            'name.required' => 'Please provide your name.',
            'email.required' => 'Please provide your email.',
            'username.required'=> 'Please provide your username',
            'role.required' => 'Please provide role',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a file of type: jpeg, png, jpg, gif, svg.',
            'profile_picture.max' => 'The profile picture may not be greater than 2MB.',
        ]);

        // Handle profile picture upload
        $filePath = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('uploads/profile_pictures/'), $filename);
            $filePath = 'uploads/profile_pictures/' . $filename;
        }

        // Create the user with the uploaded profile picture path if available
        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => 'bisucandijay', // This should be securely hashed (not plain text)
            'username' => $request->username,
            'role_id' => $request->role,
            'profile_pic' => $filePath,  // Save the file path to the database
            'active' => $request->active ?? 1,
        ]);

        // Log the created data (optional for debugging)
        error_log('Created Data: ' . print_r($data->toArray(), true));
        Log::info('Data created:', $data->toArray());

        // Redirect to the users index page
        return redirect()->route('admin.users.index');
    }



    public function update(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'username' => 'required|string|max:255',
        'role' => 'required|exists:roles,id',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate profile picture upload
    ]);

    // Find the user by ID
    $user = User::findOrFail($id);

    // Update user information
    $user->name = $request->name;
    $user->email = $request->email;
    $user->username = $request->username;
    $user->role_id = $request->role;
    $user->active = $request->active ?? 1;

    // Handle profile picture update (if a new one is uploaded)
    if ($request->hasFile('profile_picture')) {
        // Delete the old profile picture if exists
        if ($user->profile_picture && file_exists(public_path($user->profile_picture))) {
            unlink(public_path($user->profile_picture));
        }

        // Handle the new profile picture upload
        $file = $request->file('profile_picture');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $file->move(public_path('uploads/profile_pictures/'), $filename);
        $user->profile_pic = 'uploads/profile_pictures/' . $filename;
    }

    // Save the updated user
    $user->save();

    // Redirect with success message
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
