<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card {
            background-color: var(--card-bg);
            color: var(--text-color);
            max-width: 600px;
            width: 100%;
            margin-top: 50px;
            padding: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-logout {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-logout:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="shadow-lg card">
        <div class="text-end">

        </div>

        <h2 class="mb-4 text-center">Welcome, {{ $studentData->name }}</h2>
        <p class="text-center">{{ $studentData->email }}</p>

        <h3 class="mt-4">Enrolled Subjects:</h3>
        @if($studentData->userSubjects->isEmpty())
            <p class="text-muted">No subjects enrolled yet.</p>
        @else
            <ul class="mt-3 list-group">
                @foreach($studentData->userSubjects as $userSubject)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $userSubject->subject->name }}
                        <span class="badge bg-primary rounded-pill">{{ $userSubject->grade }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Link to Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
