<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function ShowLogin()
    {
        return view('login');
    }
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|max:255|confirmed',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        $user->addRole('landlord');

        return redirect('/login')->with('success', 'Landlord registered successfully!');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on role
            if ($user->hasRole('admin')) {
                return redirect('/admin/dashboard');
            } elseif ($user->hasRole('landlord')) {
                return redirect('/landlord/dashboard');
            } elseif ($user->hasRole('student')) {
                return redirect('/student/apartments');
            } else {
                Auth::logout(); // no valid role
                return redirect('/login')->withErrors([
                    'email' => 'Your account does not have a role assigned.',
                ]);
            }
        }
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }
    public function ShowRegister()
    {
        return view('register');
    }
    public function logout(Request $request)
    {
        Auth::logout(); // log out the user

        $request->session()->invalidate(); // invalidate the session
        $request->session()->regenerateToken(); // regenerate CSRF token

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
