<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserLog;

class UserController extends Controller
{
    public function index()
    {
        $userList = User::orderByRaw("FIELD(role, 'admin', 'manager', 'user')")
            ->get();

        return view('inventory.user', compact('userList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,user'
        ]);
        User::create($validated);

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User Created: {$request->name}"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'role' => 'required|in:admin,manager,user'
        ]);

        $user = User::findOrFail($id);
        $userOldName = $user->name;
        $userOldEmail = $user->email;
        $userOldRole = $user->role;
        $user->update($validated);
        $userNewName = $user->name;
        $userNewEmail = $user->email;
        $userNewRole = $user->role;

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User Updated: {$userOldName} -> {$userNewName} | {$userOldEmail} -> {$userNewEmail} | {$userOldRole} -> {$userNewRole}"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil di edit');
    }

    public function updatePassword(Request $request, string $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findOrFail($id);
        $user->update($validated);

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "Password User {$user->name} Updated"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User password berhasil di edit');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        // Store log
        UserLog::create([
            'sender' => Auth::user()->name,
            'log_type' => 'setup',
            'log'    => "User {$userName} berhasil didelete"
        ]);

        return redirect()->route('inventory.user')->with('success', 'User berhasil didelete');
    }
}
