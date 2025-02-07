<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FitTrack - Your Fitness Journey')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --blood-orange: #FF5349;
            --slate-gray: #2D3748;
            --white: #ffffff;
        }

        body {
            padding-top: 76px;
            font-family: 'Inter', sans-serif;
            color: var(--slate-gray);
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* Button Styles */
        .btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
        }

        .btn-primary {
            background-color: var(--blood-orange);
            border-color: var(--blood-orange);
            color: var(--white);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #ff4339;
            border-color: #ff4339;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 83, 73, 0.2);
        }

        .btn-outline-primary {
            color: var(--blood-orange);
            border-color: var(--blood-orange);
        }

        .btn-outline-primary:hover {
            background-color: var(--blood-orange);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* Navbar Styles */
        .navbar {
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            color: var(--blood-orange) !important;
        }

        .navbar.bg-transparent {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(45, 55, 72, 0.1);
        }

        .nav-link {
            color: var(--slate-gray);
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: var(--blood-orange);
        }

        /* Animation Classes */
        .animate-bounce {
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Form Styles */
        .form-control {
            border-radius: 8px;
            border: 1px solid rgba(45, 55, 72, 0.2);
            padding: 0.75rem 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--blood-orange);
            box-shadow: 0 0 0 3px rgba(255, 83, 73, 0.1);
        }

        /* Card Styles */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 12px rgba(45, 55, 72, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(45, 55, 72, 0.1);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top @if(Route::is('home')) bg-transparent @else bg-white shadow-sm @endif">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fas fa-dumbbell me-2"></i>
                <span>FitTrack</span>
            </a>
            
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('exercises.index') }}">Exercise Progress</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('weight.index') }}">Weight Tracking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('meals.index') }}">Meal Logger</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('calories.calculator') }}">Calorie Calculator</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <span class="me-3">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary">Logout</button>
                    </form>
                </div>
            </div>
            @else
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
            </div>
            @endauth
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
