<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;

class AccountController extends Controller
{
    /**
     * Show the account settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Render the account settings view
        return view('inventory.account');
    }

    /**
     * Update the authenticated user's password.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // Validate input:
        // - current_password must match the logged-in user's password
        // - new password must be at least 8 chars and confirmed (password_confirmation)
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Update user password (Laravel will automatically hash it via mutator if set on User model)
        $user->update([
            'password' => $validated['password'],
        ]);

        // Store an activity log for audit purposes
        UserLog::create([
            'sender'   => $user->name,
            'log_type' => 'account',
            'log'      => "Update Password"
        ]);

        // Redirect back with success message
        return redirect()->route('inventory.account')->with('success', 'Password berhasil diubah');
    }

    /**
     * Update the authenticated user's profile information (name and email).
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Validate profile update:
        $validated = $request->validate([
            'name'   => 'required|string|min:3',
            'email'  => 'required|email',
            'password_confirmation' => 'required|current_password'
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Store old values for logging
        $oldName = $user->name;
        $oldEmail = $user->email;

        // Update name and email
        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email']
        ]);

        // Log the profile changes (old -> new)
        UserLog::create([
            'sender'   => $user->name,
            'log_type' => 'account',
            'log'      => "Update Profile: {$oldName} -> {$validated['name']}, {$oldEmail} -> {$validated['email']}"
        ]);

        // Redirect with success message
        return redirect()->route('inventory.account')->with('success', 'User berhasil di edit');
    }
}
