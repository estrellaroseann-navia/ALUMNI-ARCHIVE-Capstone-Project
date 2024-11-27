<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <!-- Link to Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Light mode */
        :root {
            --bg-color: #f8f9fa;
            --card-bg: white;
            --text-color: #212529;
        }

        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-color: #343a40;
                --card-bg: #495057;
                --text-color: white;
            }
        }

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
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="p-4 shadow-lg card" style="width: 400px;">
        <h2 class="mb-4 text-center">Student Login</h2>

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

            <div class="mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <input type="checkbox" id="rememberMe" name="remember">
                    <label for="rememberMe" class="form-check-label">Remember me</label>
                </div>
                <a href="#" class="text-muted">Forgot password?</a>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
