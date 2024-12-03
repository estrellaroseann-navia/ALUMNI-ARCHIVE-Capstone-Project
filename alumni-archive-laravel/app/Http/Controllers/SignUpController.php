<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Requires 'password_confirmation'
            'name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            // 'gender' => 'required|in:male,female,other', // Assuming specific options
            'employment_status' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_year' => 'required|integer|min:1900|max:' . date('Y'),
            'complete_address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'batch_year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput(); // Redirect back with input and errors
        }

        try {
            // Create the user
            $user =  User::create([
                'email' => $request->input('email'),
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')), // Hash the password
            ]);
            $user->profile()->create([
                'first_name' => $request->input('first_name'),          // First Name
                'middle_name' => $request->input('middle_name'),        // Middle Name
                'last_name' => $request->input('last_name'),            // Last Name
                'gender' => $request->input('gender'),                  // Gender
                'employment_status' => $request->input('employment_status'), // Employment Status
                'employment_company' => $request->input('company_name'),      // Company Name
                'employment_year' => $request->input('employment_year'), // Employment Year
                'complete_address' => $request->input('complete_address'), // Complete Address
                'city' => $request->input('city'),                      // City
                'province' => $request->input('province'),              // Province
                'postal_code' => $request->input('postal_code'),        // Postal Code
                'country' => $request->input('country'),                // Country
                'graduate_year' => $request->input('batch_year'),          // Batch Year
            ]);

            // Redirect to the login page with a success message
            return redirect('/login')->with('success', 'Account created successfully. Please log in.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()
                ->back()
                ->with('error', 'An unexpected error occurred. Please try again.')
                ->withInput();
        }
    }
}
