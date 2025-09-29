<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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

        return redirect()->route('inventory.user')->with('success', 'User berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'role' => 'required|in:admin,manager,user'
        ]);
        User::where('id', $id)->update($validated);
        return redirect()->route('inventory.user')->with('success', 'User berhasil di edit');
    }

    public function updatePassword(Request $request, string $id)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);
        $user = User::findOrFail($id);
        $user->update($validated);
        return redirect()->route('inventory.user')->with('success', 'User password berhasil di edit');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('inventory.user')->with('success', 'User berhasil didelete');
    }
}
