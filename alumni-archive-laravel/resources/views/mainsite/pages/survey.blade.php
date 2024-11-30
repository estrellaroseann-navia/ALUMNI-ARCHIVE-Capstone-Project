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
        <form action="#" method="POST">
            @csrf

            <!-- General Information -->
            <h4 class="mb-3">A. General Information</h4>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="permanent_address" class="form-label">Permanent Address</label>
                    <input type="text" name="permanent_address" id="permanent_address" class="form-control" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="email_address" class="form-label">Email Address</label>
                    <input type="email" name="email_address" id="email_address" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <input type="text" name="mobile_number" id="mobile_number" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="civil_status" class="form-label">Civil Status</label>
                    <select name="civil_status" id="civil_status" class="form-select">
                        <option value="">Select...</option>
                        <option value="Single">Single</option>
                        <option value="Separated">Separated</option>
                        <option value="Widow/Widower">Widow/Widower</option>
                        <option value="Married">Married</option>
                        <option value="Single Parent">Single Parent</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sex" class="form-label">Sex</label>
                    <select name="sex" id="sex" class="form-select">
                        <option value="">Select...</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

            <!-- Educational Background -->
            <h4 class="mt-4 mb-3">B. Educational Background</h4>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="degree" class="form-label">Degree</label>
                    <input type="text" name="degree" id="degree" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" name="specialization" id="specialization" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="college_or_university" class="form-label">College or University</label>
                    <input type="text" name="college_or_university" id="college_or_university" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="year_graduated" class="form-label">Year Graduated</label>
                    <input type="text" name="year_graduated" id="year_graduated" class="form-control">
                </div>
            </div>

            <!-- Employment Data -->
            <h4 class="mt-4 mb-3">C. Employment Data</h4>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="employment_status" class="form-label">Employment Status</label>
                    <select name="employment_status" id="employment_status" class="form-select">
                        <option value="">Select...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Never Employed">Never Employed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="present_occupation" class="form-label">Present Occupation</label>
                    <input type="text" name="present_occupation" id="present_occupation" class="form-control">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="business_line" class="form-label">Business Line</label>
                    <input type="text" name="business_line" id="business_line" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="place_of_work" class="form-label">Place of Work</label>
                    <select name="place_of_work" id="place_of_work" class="form-select">
                        <option value="">Select...</option>
                        <option value="Local">Local</option>
                        <option value="Abroad">Abroad</option>
                    </select>
                </div>
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
