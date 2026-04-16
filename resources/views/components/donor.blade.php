<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-red-700 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">

            <!-- Brand -->
            <a href="{{ route('donor.dashboard') }}" class="flex items-center gap-2 font-bold text-lg">
                🩸 Blood Donation
            </a>

            <!-- Nav Links -->
            <div class="flex items-center gap-6 text-sm font-medium">
                <a href="{{ route('donor.dashboard') }}"
                   class="{{ request()->routeIs('donor.dashboard') ? 'underline font-bold text-white' : 'text-red-200 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('donor.donate') }}"
                   class="{{ request()->routeIs('donor.donate') ? 'underline font-bold text-white' : 'text-red-200 hover:text-white' }}">
                    Donate Blood
                </a>
                <a href="{{ route('donor.profile') }}"
                   class="{{ request()->routeIs('donor.profile') ? 'underline font-bold text-white' : 'text-red-200 hover:text-white' }}">
                    My Profile
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-white text-red-700 px-3 py-1 rounded font-semibold hover:bg-red-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="max-w-6xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 border border-green-300">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-3 rounded mb-6 border border-red-300">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="text-center text-gray-400 text-xs py-6 mt-10 border-t">
        &copy; {{ date('Y') }} Blood Donation Management System. All rights reserved.
    </footer>

</body>
</html>