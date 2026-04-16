<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold">🩸 Blood Donation</a>
            <div class="flex gap-4 items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.donors') }}"
                           class="{{ request()->routeIs('admin.donors') ? 'underline font-bold' : '' }} hover:underline">
                            Donors
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('donations.index') }}"
                           class="{{ request()->routeIs('donations.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Donations
                        </a>
                        <a href="{{ route('donor.profile.edit') }}"
                           class="{{ request()->routeIs('donor.profile.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Profile
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white text-red-700 px-3 py-1 rounded hover:bg-red-100">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold">🩸 Blood Donation</a>
            <div class="flex gap-4 items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.donors') }}"
                           class="{{ request()->routeIs('admin.donors') ? 'underline font-bold' : '' }} hover:underline">
                            Donors
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('donations.index') }}"
                           class="{{ request()->routeIs('donations.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Donations
                        </a>
                        <a href="{{ route('donor.profile.edit') }}"
                           class="{{ request()->routeIs('donor.profile.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Profile
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white text-red-700 px-3 py-1 rounded hover:bg-red-100">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Donation System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-red-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="text-xl font-bold">🩸 Blood Donation</a>
            <div class="flex gap-4 items-center">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                           class="{{ request()->routeIs('admin.dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.donors') }}"
                           class="{{ request()->routeIs('admin.donors') ? 'underline font-bold' : '' }} hover:underline">
                            Donors
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="{{ request()->routeIs('dashboard') ? 'underline font-bold' : '' }} hover:underline">
                            Dashboard
                        </a>
                        <a href="{{ route('donations.index') }}"
                           class="{{ request()->routeIs('donations.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Donations
                        </a>
                        <a href="{{ route('donor.profile.edit') }}"
                           class="{{ request()->routeIs('donor.profile.*') ? 'underline font-bold' : '' }} hover:underline">
                            My Profile
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-white text-red-700 px-3 py-1 rounded hover:bg-red-100">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>