<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;

class LoginController extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Display the login view
        return view('login');
    }

    /**
     * Handle user login attempt.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        // Validate incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log in with provided credentials
        if (Auth::attempt($credentials)) {
            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Store login action in user logs
            UserLog::create([
                'sender' => Auth::user()->name,
                'log_type' => 'account',
                'log'    => "Login"
            ]);

            // Redirect to dashboard on successful login
            return redirect()->route('inventory.dashboard');
        }

        // If login fails, redirect back with error messages and retain email input
        return back()
            ->withErrors([
                'email' => 'Email atau password salah.',
                'password' => 'Email atau password salah.',
            ])
            ->onlyInput('email');
    }

    /**
     * Handle user logout.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Store current user's name for logging before logout
        $userName = Auth::user()->name;

        // Log the user out
        Auth::logout();

        // Invalidate the session and regenerate CSRF token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Store logout action in user logs
        UserLog::create([
            'sender' => $userName,
            'log_type' => 'account',
            'log'    => "Logout"
        ]);

        // Redirect to login page after logout
        return redirect()->route('login');
    }
}
