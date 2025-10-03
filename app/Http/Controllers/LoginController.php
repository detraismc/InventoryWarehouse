<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Store log
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'account',
                'log'    => "Login"
            ]);

            return redirect()->route('inventory.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
                'password' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $userName = Auth::user()->name;
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Store log
        UserLog::create([
            'sender' => $userName,
            'log_type' => 'account',
            'log'    => "Logout"
        ]);

        return redirect()->route('login');
    }
}
