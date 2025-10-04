<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;

class UserController extends Controller
{
    /**
     * Display a list of users, ordered by role (admin > manager > user).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all users and order them by role priority
        $userList = User::orderByRaw("FIELD(role, 'admin', 'manager', 'user')")
            ->get();

        // Pass users to the view
        return view('inventory.user', compact('userList'));
    }

    /**
     * Create a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,user'
        ]);

        // Create the user
        User::create($validated);

        // Store creation action in user log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User Created: {$request->name}"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Update user information (name, email, role).
     *
     * @param Request $request
     * @param string $id User ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'role' => 'required|in:admin,manager,user'
        ]);

        // Find the user to update
        $user = User::findOrFail($id);

        // Store old values for logging
        $userOldName = $user->name;
        $userOldEmail = $user->email;
        $userOldRole = $user->role;

        // Update user with new data
        $user->update($validated);

        // Store new values for logging
        $userNewName = $user->name;
        $userNewEmail = $user->email;
        $userNewRole = $user->role;

        // Log the update action
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User Updated: {$userOldName} -> {$userNewName} | {$userOldEmail} -> {$userNewEmail} | {$userOldRole} -> {$userNewRole}"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil di edit');
    }

    /**
     * Update the password of a user.
     *
     * @param Request $request
     * @param string $id User ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, string $id)
    {
        // Validate password input
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        // Find the user and update password
        $user = User::findOrFail($id);
        $user->update($validated);

        // Log the password change
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Password User {$user->name} Updated"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User password berhasil di edit');
    }

    /**
     * Delete a user.
     *
     * @param string $id User ID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        // Find the user to delete
        $user = User::findOrFail($id);
        $userName = $user->name;

        // Delete the user
        $user->delete();

        // Log the deletion
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User {$userName} berhasil didelete"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil didelete');
    }
}
