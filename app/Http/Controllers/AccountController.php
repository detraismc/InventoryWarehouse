<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;

class AccountController extends Controller
{
    public function index()
    {
        return view('inventory.account');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->update([
            'password' => $validated['password'],
        ]);

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'account',
            'log'    => "Update Password"
        ]);

        return redirect()->route('inventory.account')->with('success', 'Password berhasil diubah');
    }


    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|min:3',
            'email'  => 'required|email',
            'password_confirmation' => 'required|current_password'
        ]);

        $user = Auth::user();
        $oldName = $user->name;
        $oldEmail = $user->email;
        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email']
        ]);


        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'account',
            'log'    => "Update Profile: {$oldName} -> {$validated['name']}, {$oldEmail} -> {$validated['email']}"
        ]);

        return redirect()->route('inventory.account')->with('success', 'User berhasil di edit');
    }

}
