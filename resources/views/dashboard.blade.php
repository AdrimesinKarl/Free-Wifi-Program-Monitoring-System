@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Action Buttons --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap items-center gap-3">
            {{-- Filters --}}
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-3">
                <select id="province_id" name="province_id" class="w-64"onchange="this.form.submit()">
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
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-icon lucide-upload">
                    <path d="M12 3v12"/><path d="m17 8-5-5-5 5"/><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>

                    Upload CSV
                </span>
                <input type="file" name="csv_file" id="csvFile" accept=".csv,.txt" class="hidden" onchange="document.getElementById('uploadForm').submit()">
            </label>
        </form>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @error('csv_file')
        <div class="mb-6 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ $message }}
        </div>
    @enderror

    {{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 font-medium">Total Sites</p>
            <span class="bg-blue-50 text-blue-500 p-2 rounded-lg">
                <i data-lucide="map-pin" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold text-gray-900">{{ $total }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 font-medium">Active</p>
            <span class="bg-green-50 text-green-500 p-2 rounded-lg">
                <i data-lucide="circle-check" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold text-green-600">{{ $active }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 font-medium">For Renewal</p>
            <span class="bg-yellow-50 text-yellow-500 p-2 rounded-lg">
                <i data-lucide="clock" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold text-yellow-500">{{ $forRenewal }}</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500 font-medium">Terminated</p>
            <span class="bg-red-50 text-red-500 p-2 rounded-lg">
                <i data-lucide="circle-x" class="w-4 h-4"></i>
            </span>
        </div>
        <p class="text-3xl font-bold text-red-500">{{ $terminated }}</p>
    </div>

</div>

    {{-- ── Bar Chart ── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="text-base font-semibold text-gray-700">
                Locations per {{ $selectedProvince ? 'Municipality' : 'Province' }}
            </h2>
        </div>
        <p class="text-sm text-gray-400 mb-4">
            @if($selectedProvince)
                Showing municipalities in
                <strong>{{ $provinces->find($selectedProvince)?->name }}</strong>
            @else
                Showing all provinces
            @endif
            @if($selectedStatus)
                &mdash; Status:
                <strong>{{ $statuses->find($selectedStatus)?->name }}</strong>
            @endif
        </p>

        <div id="locationChart" data-chart='@json($chartData)'></div>
    </div>

</div>

@push('scripts')
@vite(['resources/js/charts/wifiChart.js'])
@endpush

    {{-- Reset Button --}}
    <div class="mt-4">
        <form method="POST" action="{{ route('locations.reset') }}" onsubmit="return confirm('Reset all locations? This cannot be undone.')" class="inline">
            @csrf
            <button type="submit" class="px-4 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors border border-red-200 hover:border-red-300">
                Reset All Locations
            </button>
        </form>
    </div>
</div>
@endsection

