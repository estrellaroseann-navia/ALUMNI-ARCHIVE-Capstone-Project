<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $studentData = User::with('userSubjects')->find(auth('student')->id());
        return view('student-dashboard.layouts.app', compact('studentData')); // Create a view for the student dashboard
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
