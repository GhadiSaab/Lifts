<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Workout Logger')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        .sidebar.open {
            transform: translateX(0);
        }
        .overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out;
        }
        .overlay.open {
            opacity: 0.5;
            visibility: visible;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Mobile Sidebar -->
    <div class="overlay fixed inset-0 bg-black z-40" id="overlay"></div>
    <div class="sidebar fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50 md:hidden">
        <div class="p-4 border-b">
            <div class="flex items-center justify-between">
                <span class="text-xl font-bold text-gray-800">Menu</span>
                <button id="closeSidebar" class="text-gray-500 hover:text-gray-700">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <nav class="p-4">
            <div class="space-y-4">
                <a href="{{ route('exercises.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    Exercise Progress
                </a>
                <a href="{{ route('exercises.create') }}" class="flex items-center px-4 py-2 text-blue-600 hover:bg-blue-50 rounded-md">
                    Add New Exercise
                </a>
                <a href="{{ route('weight.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    Weight Tracking
                </a>
                <a href="{{ route('meals.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    Meal Logger
                </a>
                <a href="{{ route('calories.calculator') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-md">
                    Calorie Calculator
                </a>
            </div>
        </nav>
    </div>
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <button id="openSidebar" class="md:hidden mr-4 text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('exercises.index') }}" class="text-xl font-bold text-gray-800">
                            Workout Logger
                        </a>
                    </div>
                    @auth
                        <!-- Desktop Navigation -->
                        <div class="hidden md:ml-6 md:flex md:space-x-8">
                            <a href="{{ route('exercises.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Exercise Progress
                            </a>
                            <a href="{{ route('exercises.create') }}" class="inline-flex items-center px-1 pt-1 text-blue-600 hover:text-blue-700">
                                Add New Exercise
                            </a>
                            <a href="{{ route('weight.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Weight Tracking
                            </a>
                            <a href="{{ route('meals.index') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Meal Logger
                            </a>
                            <a href="{{ route('calories.calculator') }}" class="inline-flex items-center px-1 pt-1 text-gray-500 hover:text-gray-700">
                                Calorie Calculator
                            </a>
                        </div>
                    @endauth
                </div>
                <div class="flex items-center">
                    @auth
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-500 hover:text-gray-700">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <script>
        // Mobile sidebar functionality
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.overlay');
        const openButton = document.querySelector('#openSidebar');
        const closeButton = document.querySelector('#closeSidebar');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        openButton.addEventListener('click', openSidebar);
        closeButton.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);
    </script>
</body>
</html>
