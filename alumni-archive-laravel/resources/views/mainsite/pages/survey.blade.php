@extends('mainsite.layouts.app')
@section('content')
 <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Tracking Survey Form</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
       <div class="container mt-5">
        <h1 class="mb-4">Graduate Tracer Study Form</h1>
      <form action="{{ route('send.survey') }}" method="POST">
    @csrf

    <!-- Graduation Year and Program -->
    <h4 class="mb-3">A. General Information</h4>
    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="graduation_year" class="form-label">Graduation Year</label>
            <input type="number" name="graduation_year" id="graduation_year" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="program" class="form-label">Degree/Program Completed</label>
            <input type="text" name="program" id="program" class="form-control" required>
        </div>
    </div>

    <!-- Employment Status -->
    <h4 class="mt-4 mb-3">B. Employment Information</h4>
    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="employment_status" class="form-label">Employment Status</label>
            <select name="employment_status" id="employment_status" class="form-select" required>
                <option value="">Select...</option>
                <option value="Employed">Employed</option>
                <option value="Unemployed">Unemployed</option>
                <option value="Self-employed">Self-employed</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="company_name" class="form-label">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control">
        </div>
    </div>
    <div class="mb-3 row">
        <div class="col-md-6">
            <label for="job_title" class="form-label">Job Title</label>
            <input type="text" name="job_title" id="job_title" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="is_job_related_to_degree" class="form-label">Is the Job Related to Your Degree?</label>
            <select name="is_job_related_to_degree" id="is_job_related_to_degree" class="form-select">
                <option value="">Select...</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
    </div>

    <!-- Feedback -->
    <h4 class="mt-4 mb-3">C. Feedback</h4>
    <div class="mb-3">
        <label for="feedback_on_education" class="form-label">Feedback on Education</label>
        <textarea name="feedback_on_education" id="feedback_on_education" rows="3" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label for="skills_needed" class="form-label">Skills Needed to Advance Career</label>
        <textarea name="skills_needed" id="skills_needed" rows="3" class="form-control"></textarea>
    </div>

    <!-- Submit Button -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

    </div>
    <!-- /Contact Section -->
  </main>
@endsection
