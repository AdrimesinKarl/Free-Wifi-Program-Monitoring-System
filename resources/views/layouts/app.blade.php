<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fwmps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- Header --}}
    <header class="bg-white shadow px-6 py-4 flex items-center justify-between">
        <span class="font-bold text-emerald-700 text-lg">Free WiFi Management</span>

        <nav class="flex gap-6">
            <a href="{{ route('dashboard') }}"
                class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                Dashboard
            </a>
            <a href="{{ route('map') }}"
                class="text-sm {{ request()->routeIs('map') ? 'font-semibold text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                Location Mapping
            </a>
            <a href="{{ route('project-status') }}"
                class="text-sm {{ request()->routeIs('project-status') ? 'font-semibold text-emerald-600' : 'text-gray-600 hover:text-gray-900' }}">
                Project Status
            </a>
        </nav>
    </header>

    {{-- Page Content --}}
    <main class="p-6">
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>