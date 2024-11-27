<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentLoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('student-dashboard.layouts.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to log in the student using the 'student' guard
        if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $student = Auth::guard('student')->user();

            // Ensure the logged-in user is a student (not an admin)
            if ($student->is_admin === 0) {
                return redirect()->intended('/');
            } else {
                // If the user is an admin, log them out and show an error
                Auth::guard('student')->logout();
                return redirect()->back()->withErrors([
                    'email' => 'You are an admin, please log in through the admin portal.',
                ]);
            }
        }

        // If login fails, return with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
