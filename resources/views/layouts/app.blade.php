<!DOCTYPE html>
<html lang="en" class="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>fwmps</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 dark:bg-slate-950 min-h-screen text-slate-900 dark:text-slate-100">

<div class="flex min-h-screen">

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/40 z-20 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-56 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col shadow-sm -translate-x-full lg:translate-x-0 transition-transform duration-200">

        {{-- Brand --}}
    <div class="px-5 py-5 border-b border-slate-200 dark:border-slate-800">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wifi shrink-0 text-slate-900 dark:text-slate-100">
                <path d="M12 20h.01"/>
                <path d="M2 8.82a15 15 0 0 1 20 0"/>
                <path d="M5 12.859a10 10 0 0 1 14 0"/>
                <path d="M8.5 16.429a5 5 0 0 1 7 0"/>
            </svg><br>
            <span class="font-bold text-slate-900 dark:text-slate-100 text-base leading-tight">
            Free Wifi<br>Monitoring System
            </span>
    </div>
    </div>

        {{-- Navigation --}}
        <nav class="flex flex-col gap-1 p-3 flex-1">

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                {{ request()->routeIs('dashboard')
                    ? 'bg-violet-50 dark:bg-violet-950 font-semibold text-violet-600 dark:text-violet-400'
                    : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-violet-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="9" x="3" y="3" rx="1"/>
                    <rect width="7" height="5" x="14" y="3" rx="1"/>
                    <rect width="7" height="9" x="14" y="12" rx="1"/>
                    <rect width="7" height="5" x="3" y="16" rx="1"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('map') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                {{ request()->routeIs('map')
                    ? 'bg-violet-50 dark:bg-violet-950 font-semibold text-violet-600 dark:text-violet-400'
                    : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-violet-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
                Location Mapping
            </a>

            <a href="{{ route('project-status') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-colors
                {{ request()->routeIs('project-status')
                    ? 'bg-violet-50 dark:bg-violet-950 font-semibold text-violet-600 dark:text-violet-400'
                    : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-violet-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8v4"/>
                    <path d="M12 16h.01"/>
                </svg>
                Project Status
            </a>
        </nav>

    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Mobile Top Bar --}}
        <header class="lg:hidden flex items-center gap-4 px-4 py-3 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-sm">
            <button onclick="toggleSidebar()" class="p-2 rounded-lg text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                {{-- Hamburger --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="18" x2="20" y2="18"/>
                </svg>
            </button>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wifi shrink-0 text-slate-900 dark:text-slate-100">
                <path d="M12 20h.01"/>
                <path d="M2 8.82a15 15 0 0 1 20 0"/>
                <path d="M5 12.859a10 10 0 0 1 14 0"/>
                <path d="M8.5 16.429a5 5 0 0 1 7 0"/>

            </svg>
            <span class="font-bold text-slate-900 dark:text-slate-100 text-sm">Free Wifi Program Monitoring System </span>
        </header>

        {{-- Page Content --}}
        <main class="px-6 pt-10 pb-6 flex-1">
            @yield('content')
        </main>

    </div>

</div>

@stack('scripts')

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>

</body>


