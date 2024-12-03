<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
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

    <div class="p-4 shadow-lg card" style="width: 400px;">
        <h2 class="mb-4 text-center">Student Login</h2>
         @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <form action="{{ route('login') }}" method="POST">
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

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
            <br>
            <br>
            <a  class="btn btn-primary w-100" href="{{ url('/register') }}">Sign Up</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
