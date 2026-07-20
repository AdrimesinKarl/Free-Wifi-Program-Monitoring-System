@extends('layouts.app')

@section('content')

@include('partials.toast')

{{-- Page Header --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Dashboard</h1>
    <p class="text-slate-500 dark:text-slate-400">Welcome to the Free WiFi Monitoring dashboard</p>
</div>

{{-- Action Buttons --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">

    <div class="flex flex-wrap items-center gap-3">
        {{-- Filters --}}
        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-3">

            <select id="province_id" name="province_id" class="w-64" onchange="this.form.submit()">
                <option value="">All Provinces</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ $selectedProvince == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>

            <select id="status_id" name="status_id" class="w-64" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $selectedStatus == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>

        </form>
    </div>

    {{-- Upload CSV Button --}}
    <form method="POST" action="{{ route('locations.upload') }}" enctype="multipart/form-data" class="flex items-center gap-3" id="uploadForm">
        @csrf
        <label for="csvFile" class="cursor-pointer">
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-violet-600 text-white rounded-xl text-sm font-medium shadow-sm hover:bg-violet-700 hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload">
                    <path d="M12 3v12"/>
                    <path d="m17 8-5-5-5 5"/>
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                </svg>
                Upload CSV
            </span>
            <input
                type="file"
                name="csv_file"
                id="csvFile"
                accept=".csv,.txt"
                class="hidden"
                onchange="document.getElementById('uploadForm').submit()">
        </label>
    </form>

</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Sites</p>
            <span class="bg-violet-50 dark:bg-violet-950 text-violet-600 dark:text-violet-400 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                    <circle cx="12" cy="10" r="3"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ $total }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Active</p>
            <span class="bg-green-50 dark:bg-green-950 text-green-600 dark:text-green-400 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $active }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">For Renewal</p>
            <span class="bg-yellow-50 dark:bg-yellow-950 text-yellow-600 dark:text-yellow-400 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-yellow-500 dark:text-yellow-400">{{ $forRenewal }}</p>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-8 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Terminated</p>
            <span class="bg-red-50 dark:bg-red-950 text-red-600 dark:text-red-400 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m15 9-6 6"/>
                    <path d="m9 9 6 6"/>
                </svg>
            </span>
        </div>
        <p class="text-3xl font-bold text-red-500 dark:text-red-400">{{ $terminated }}</p>
    </div>

</div>

{{-- Bar Chart --}}
<div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 hover:shadow-md transition-shadow">
    <div class="flex items-center justify-between mb-1">
        <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">
            Locations per {{ $selectedProvince ? 'Municipality' : 'Province' }}
        </h2>
    </div>
    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">
        @if($selectedProvince)
            Showing municipalities in
            <strong class="text-slate-700 dark:text-slate-200">
                {{ $provinces->find($selectedProvince)?->name }}
            </strong>
        @else
            Showing all provinces
        @endif
        @if($selectedStatus)
            &mdash; Status:
            <strong class="text-slate-700 dark:text-slate-200">
                {{ $statuses->find($selectedStatus)?->name }}
            </strong>
        @endif
    </p>
    <div id="locationChart" data-chart='@json($chartData)'>

</div>


@push('scripts')
@vite(['resources/js/charts/wifiChart.js'])
@endpush

{{-- Reset Button --}}
<div class="mt-4 flex justify-end">
    <form method="POST" action="{{ route('locations.reset') }}" onsubmit="return confirm('Reset all locations? This cannot be undone.')" class="inline">
        @csrf
        <button type="submit"
                class="px-4 py-2 text-sm
                text-red-700 dark:text-red-400
                hover:text-red-800 dark:hover:text-red-300
                hover:bg-red-50 dark:hover:bg-red-950
                rounded-lg transition-colors
                border border-red-200 dark:border-red-800">
            Reset All Locations
        </button>
    </form>
</div>

@endsection