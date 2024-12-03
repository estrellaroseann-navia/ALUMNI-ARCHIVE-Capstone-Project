<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function storeSurvey(Request $request)
    {
        dd('shit');
        $user_id = auth('student')->id();
        // Validate the incoming request data
        $validatedData = $request->validate([
            'graduation_year' => 'required|integer|digits:4', // Graduation year validation
            'program' => 'nullable|string|max:255', // Program or degree
            'employment_status' => 'nullable|string|in:Employed,Unemployed,Self-employed', // Limit to specific statuses
            'company_name' => 'nullable|string|max:255', // Optional company name
            'job_title' => 'nullable|string|max:255', // Optional job title
            'is_job_related_to_degree' => 'nullable|boolean', // Accept true/false values
            'feedback_on_education' => 'nullable|string', // Optional feedback
            'skills_needed' => 'nullable|string', // Optional skills
        ]);

        // Create the survey record using the validated data
        Survey::create([
            'user_id' => $user_id, // User ID from the request
            'graduation_year' => $validatedData['graduation_year'], // Graduation year
            'program' => $validatedData['program'], // Program or degree
            'employment_status' => $validatedData['employment_status'], // Employment status
            'company_name' => $validatedData['company_name'], // Company name
            'job_title' => $validatedData['job_title'], // Job title
            'is_job_related_to_degree' => $validatedData['is_job_related_to_degree'], // Related to degree
            'feedback_on_education' => $validatedData['feedback_on_education'], // Feedback
            'skills_needed' => $validatedData['skills_needed'], // Skills needed
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('message', 'Survey submitted successfully!');
    }
}
