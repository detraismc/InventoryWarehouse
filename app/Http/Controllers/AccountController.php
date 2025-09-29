<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email']
        ]);

        return redirect()->route('inventory.account')->with('success', 'User berhasil di edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
