<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <!-- Link to Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
      /* PSU Color Palette */
:root {
    --bg-color: #f8f9fa; /* Light background */
    --card-bg: white; /* Card background */
    --text-color: #212529; /* Default text color */

    --psu-orange: #f27c28; /* PSU Orange */
    --psu-blue: #006fa6; /* PSU Blue */
    --psu-yellow: #ffcc00; /* PSU Yellow/Gold */

    --default-color: var(--psu-orange); /* PSU primary color */
    --heading-color: var(--psu-blue); /* PSU blue for headings */
    --accent-color: var(--psu-yellow); /* PSU yellow for accents */
    --surface-color: #e9ecef; /* Surface color */
    --contrast-color: #343a40; /* Dark contrast color */
}

/* Light mode */
body {
    background-color: var(--bg-color);
    color: var(--text-color);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.card {
    background-color: var(--card-bg);
    color: var(--text-color);
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Button styles */
.btn-primary {
    background-color: var(--default-color); /* PSU Orange */
    border-color: var(--default-color);
}

.btn-primary:hover {
    background-color: var(--heading-color); /* PSU Blue */
    border-color: var(--heading-color);
}

/* Dark mode */
@media (prefers-color-scheme: dark) {
    :root {
        --bg-color: #343a40; /* Dark background */
        --card-bg: #495057; /* Dark card background */
        --text-color: white; /* White text color for dark mode */

        --default-color: var(--psu-orange);
        --heading-color: var(--psu-yellow); /* Use yellow for headings in dark mode */
        --accent-color: var(--psu-yellow);
        --surface-color: #495057;
        --contrast-color: #ffffff; /* White contrast color */
    }
}

/* Accent and surface usage */
.accent-text {
    color: var(--accent-color); /* PSU Yellow */
}

.surface {
    background-color: var(--surface-color);
}

.high-contrast {
    color: var(--contrast-color);
}

    </style>
</head>

<body>

    <div  style="margin-top: 1000px"class="p-4 shadow-lg card">
        <h2 class="mb-4 text-center">Alumni Registration</h2>

        <form action="{{ route('register') }}" method="POST">
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
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter your first name" required>
                </div>
                <div class="col-md-6">
                    <label for="middle_name" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Enter your middle name">
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter your last name" required>
                </div>
                <div class="col-md-6">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>



            <!-- Password Fields -->
            <h3 style="color: #f27c28;">Account Information</h3>
            <div class="mb-3 row">
                   <div class="col-md-6">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your user name" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Corporate Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
            </div>

            <!-- Employment Fields in 2 columns -->
            <h3 style="color: #f27c28;">Employment Information</h3>
            <div class="mb-3 row">
            <div class="col-md-6"> <label for="employment_status" class="form-label">Employment Status</label> <select class="form-control" id="employment_status" name="employment_status" required> <option value="">Select your employment status</option> <option value="Employed">Employed</option> <option value="Unemployed">Unemployed</option> <option value="Untracked">Untracked</option> </select> </div>
                <div class="col-md-6">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter your company name" required>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="employment_year" class="form-label">Year of Employment</label>
                    <input type="number" class="form-control" id="employment_year" name="employment_year" placeholder="Enter your employment year" required>
                </div>
                <div class="col-md-6">
                    <label for="occupational_status" class="form-label">Occupational Status</label>
                    <select class="form-control" id="occupational_status" name="occupational_status" required>
                        <option value="">Select your occupational status</option>
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
                <input type="number" class="form-control" id="batch_year" name="batch_year" placeholder="Enter your batch year" required>
            </div>

            <!-- TRY TRY -->

            <div class="mb-3 row">
               <div class="col-md-6">
                    <label for="occupational_status" class="form-label">
                        Program
                    </label>
                    <select class="form-control select" id="occupational_status" name="program_id" required>
                        <option value="">Select your occupational status</option>
                        @foreach ($programs as $program )
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach

                    </select>
                </div>
                   <div class="col-md-6">
                    <label for="occupational_status" class="form-label">
                        Campus
                    </label>
                    <select class="form-control select" id="occupational_status" name="campus_id" required>
                        <option value="">Select your occupational status</option>
                        @foreach ($campuses as $campus )
                            <option value="{{ $campus->id }}">{{ $campus->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>

            <!-- Address Fields in 2 columns -->
            <h3 style="color: #f27c28;">Address Information</h3>
            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="complete_address" class="form-label">Complete Address</label>
                    <input type="text" class="form-control" id="complete_address" name="complete_address" placeholder="Enter your complete address">
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="province" class="form-label">Province</label>
                    <input type="text" class="form-control" id="province" name="province" placeholder="Enter your province">
                </div>
                <div class="col-md-6">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Enter your postal code">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Enter your country">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

