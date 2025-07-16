<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Truck Admin - @yield('title')</title>

    <!-- Tailwind CSS CDN - For quick development. For production, compile assets. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Light gray background */
        }
        /* Basic styling for flash messages */
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }
        .alert-success {
            background-color: #d1fae5; /* Light green */
            color: #065f46; /* Dark green text */
            border: 1px solid #34d399;
        }
        .alert-error {
            background-color: #fee2e2; /* Light red */
            color: #991b1b; /* Dark red text */
            border: 1px solid #ef4444;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    <nav class="bg-blue-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('admin.food_trucks.index') }}" class="text-white text-2xl font-bold rounded-md px-3 py-2 hover:bg-blue-700 transition duration-300">
                Food Truck Admin
            </a>
            <div>
                <a href="{{ route('admin.food_trucks.index') }}" class="text-white hover:text-blue-200 rounded-md px-3 py-2 transition duration-300">
                    Food Trucks
                </a>
                {{-- You can add more navigation links here for other admin sections --}}
                {{-- <a href="#" class="text-white hover:text-blue-200 rounded-md px-3 py-2 transition duration-300">Users</a> --}}
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-6 flex-grow">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white p-4 text-center mt-auto">
        <div class="container mx-auto">
            &copy; {{ date('Y') }} Food Truck Admin. All rights reserved.
        </div>
    </footer>
</body>
</html>
