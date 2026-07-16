<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fwmps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-slate-100 dark:bg-slate-950 min-h-screen text-slate-900 dark:text-slate-100">
{{-- Header --}}
<header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm px-6 py-4 flex items-center justify-between">

    {{-- Brand --}}
    <span class="font-bold text-slate-900 dark:text-slate-100 text-lg">
        Free WiFi Management
    </span>


    {{-- Navigation --}}
<nav class="flex items-center gap-6">

    <a href="{{ route('dashboard') }}"
        class="flex items-center gap-1.5 text-sm {{ request()->routeIs('dashboard') ? 'font-semibold text-violet-600' : 'text-slate-600 dark:text-slate-400 hover:text-violet-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect width="7" height="9" x="3" y="3" rx="1"/>
            <rect width="7" height="5" x="14" y="3" rx="1"/>
            <rect width="7" height="9" x="14" y="12" rx="1"/>
            <rect width="7" height="5" x="3" y="16" rx="1"/>
        </svg>
        Dashboard
    </a>

    <a href="{{ route('map') }}"
        class="flex items-center gap-1.5 text-sm {{ request()->routeIs('map') ? 'font-semibold text-violet-600' : 'text-slate-600 dark:text-slate-400 hover:text-violet-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
            <circle cx="12" cy="10" r="3"/>
        </svg>
        Map
    </a>

    <a href="{{ route('project-status') }}"
        class="flex items-center gap-1.5 text-sm {{ request()->routeIs('project-status') ? 'font-semibold text-violet-600' : 'text-slate-600 dark:text-slate-400 hover:text-violet-600' }}">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <path d="M12 8v4"/>
            <path d="M12 16h.01"/>
        </svg>
        Status
    </a>

</nav>


        {{-- Dark Mode Toggle --}}
<button id="theme-toggle"
    class="p-2 rounded-lg bg-slate-100 text-slate-700
    hover:bg-slate-200
    dark:bg-slate-800 dark:text-slate-200
    dark:hover:bg-slate-700 transition">

    <i data-lucide="moon" class="w-5 h-5 dark:hidden"></i>
    <i data-lucide="sun" class="w-5 h-5 hidden dark:block"></i>

</button>

    </nav>

</header>

    {{-- Page Content --}}
    <main class="p-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>