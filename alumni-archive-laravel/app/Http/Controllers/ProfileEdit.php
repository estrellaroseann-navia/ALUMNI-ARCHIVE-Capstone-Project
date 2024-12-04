<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Campus;
use App\Models\Program;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileEdit extends Controller
{
    public function index()
    {
        $campuses = Campus::all();
        $programs = Program::all();
        $user = User::find(auth('student')->id());
        $user_profile = auth('student')->user()->profile;

        return view('mainsite.pages.profile-edit', compact('campuses', 'programs', 'user', 'user_profile'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            // 'email' => 'required|email|unique:users,email,' . auth('student')->id(), // Exclude the current user from uniqueness check
            'password' => 'nullable|min:8|confirmed', // Password is optional for updates
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'employment_status' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_year' => 'required|integer|min:1900|max:' . date('Y'),
            'complete_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            // 'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            // 'batch_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput(); // Redirect back with input and errors
        }

        try {
            // Get the logged-in student
            $user = auth('student')->user();

            // Update the user's main details
            $user->update([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                // Only hash the password if it's provided
                'password' => $request->input('password') ? Hash::make($request->input('password')) : $user->password,
            ]);

            // Update the user's profile details
            $user->profile()->updateOrCreate([], [
                'first_name' => $request->input('first_name'),
                'middle_name' => $request->input('middle_name'),
                'last_name' => $request->input('last_name'),
                'gender' => $request->input('gender'),
                'employment_status' => $request->input('employment_status'),
                'occupational_status' => $request->input('occupational_status'),
                'employment_company' => $request->input('company_name'),
                'employment_year' => $request->input('employment_year'),
                'complete_address' => $request->input('complete_address'),
                'city' => $request->input('city'),
                'province' => $request->input('province'),
                'postal_code' => $request->input('postal_code'),
                'country' => $request->input('country'),
                'graduate_year' => $request->input('batch_year'),
            ]);

            // Redirect to a success page or back with success message
            return redirect()->back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            \Log::error($e->getMessage());

            // Return an error message
            return redirect()
                ->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput();
        }
    }
}
