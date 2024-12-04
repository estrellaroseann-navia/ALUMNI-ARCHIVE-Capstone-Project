@extends('mainsite.layouts.app')
@section('content')

<br>
<br>
<br>
    <main class="main">
        <div class="container">
               <div  class="p-4 shadow-lg card">
        <h2 class="mb-4 text-center">Alumni Registration</h2>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <!-- Display session errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Name Fields in 2 columns -->
             <h3 style="color: #f27c28;">Personal Information</h3>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" value="{{ $user_profile->first_name }}" name="first_name" placeholder="Enter your first name" required>
                </div>
                <div class="col-md-6">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" value="{{ $user_profile->middle_name }}" id="middle_name" name="middle_name" placeholder="Enter your middle name">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" value="{{ $user_profile->last_name }}"  name="last_name" placeholder="Enter your last name" required>
                </div>
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option selected value="{{ $user_profile->gender }}">{{ $user_profile->gender }}</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>



            <!-- Password Fields -->
            <h3 style="color: #f27c28;">Account Information</h3>
            <div class="mb-3 row">
                   <div class="col-md-6">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"   placeholder="Enter your user name" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Corporate Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled name="email" placeholder="Enter your email" required>
                    <small class="text-gray-100">You can't change your email, Please contact admin</small>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" >
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" >
                </div>
            </div>

            <!-- Employment Fields in 2 columns -->
            <h3 style="color: #f27c28;">Employment Information</h3>
            <div class="mb-3 row">
            <div class="col-md-6"> <label for="employment_status" class="form-label">Employment Status</label>
                <select class="form-control" id="employment_status" name="employment_status" required>
                    <option selected value="{{ $user_profile->employment_status }}">{{ $user_profile->employment_status }}</option>
                    <option value="Employed">Employed</option> <option value="Unemployed">Unemployed</option>
                    <option value="Untracked">Untracked</option>
                </select>
                </div>
                <div class="col-md-6">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" value="{{ $user_profile->employment_company }}"  id="company_name" name="company_name" placeholder="Enter your company name" required>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="employment_year" class="form-label">Year of Employment</label>
                    <input type="number" class="form-control" id="employment_year" name="employment_year" value="{{ $user_profile->employment_year }} placeholder="Enter your employment year" required>
                </div>
                <div class="col-md-6">
                    <label for="occupational_status" class="form-label">Occupational Status</label>
                    <select class="form-control" id="occupational_status" name="occupational_status" required>
                        <option selected value="{{ $user_profile->occupational_status }}">{{ $user_profile->occupational_status }}</option>
                        <option value="Public">Public</option>
                        <option value="Private">Private</option>
                        <option value="Government">Government</option>
                        <option value="Self-Employed">Self-Employed</option>
                    </select>
                </div>
            </div>



            <h3 style="color: #f27c28;">Academic Information</h3>
            <div class="col-md-12">
                <label for="batch_year" class="form-label">Year Graduated</label>
                <input type="number" class="form-control" id="batch_year" name="batch_year" value="{{ $user_profile->graduate_year }}" placeholder="Enter your batch year" required>
            </div>

            <!-- TRY TRY -->

            <div class="mb-3 row">
               <div class="col-md-6">
                    <label for="occupational_status" class="form-label">
                        Program
                    </label>
                    <select class="form-control select" id="occupational_status" name="program_id" required>
                        <option value="">Select your occupational status</option>
                         @foreach ($programs as $program)
                            <option value="{{ $program->id }}"
                                @if ($program->id == $user_profile->program_id) selected @endif>
                                {{ $program->name }}
                            </option>
                        @endforeach


                    </select>
                </div>
                   <div class="col-md-6">
                    <label for="occupational_status" class="form-label">
                        Campus
                    </label>
                    <select class="form-control select" id="occupational_status" name="campus_id" required>
                        @foreach ($campuses as $campus)
                            <option value="{{ $campus->id }}"
                                @if ($campus->id == $user_profile->campus_id) selected @endif>
                                {{ $campus->name }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- Address Fields in 2 columns -->
            <h3 style="color: #f27c28;">Address Information</h3>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="complete_address" class="form-label">Complete Address</label>
                    <input type="text" class="form-control" id="complete_address" value="{{ $user_profile->complete_address }}"  name="complete_address" placeholder="Enter your complete address">
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ $user_profile->city }}" placeholder="Enter your city">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" value="{{ $user_profile->province }}" placeholder="Enter your province">
                </div>
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $user_profile->postal_code }}" placeholder="Enter your postal code">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" value="{{ $user_profile->country }}" placeholder="Enter your country">
                </div>
            </div>

            <button type="submit" style="background-color: #f27c28" class="text-white btn w-100">Update</button>
        </form>
    </div>
        </div>






    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form"); // Replace with the appropriate form selector
    const password = document.getElementById("password");
    const passwordConfirmation = document.getElementById("password_confirmation");
    const errorMessage = document.createElement("div");
    errorMessage.style.color = "red";
    errorMessage.style.marginTop = "5px";
    errorMessage.style.display = "none"; // Initially hidden
    errorMessage.textContent = "Passwords do not match.";

    passwordConfirmation.parentNode.appendChild(errorMessage); // Add the error message below confirmation input

    form.addEventListener("submit", function (e) {
        if (passwordConfirmation.value.trim() !== "" && password.value !== passwordConfirmation.value) {
            e.preventDefault(); // Prevent form submission
            errorMessage.style.display = "block"; // Show error message
        } else {
            errorMessage.style.display = "none"; // Hide error message
        }
    });

    // Optionally, add live validation feedback as the user types
    passwordConfirmation.addEventListener("input", function () {
        if (passwordConfirmation.value.trim() !== "" && password.value === passwordConfirmation.value) {
            errorMessage.style.display = "none";
        }
    });
});

    </script>
@endsection
