@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Action Buttons --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex flex-wrap items-center gap-3">
            {{-- Filters --}}
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-3">
                <select name="province_id" onchange="this.form.submit()"
                    class="border rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Provinces</option>
                    @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ $selectedProvince == $province->id ? 'selected' : '' }}>
                            {{ $province->name }}
                        </option>
                    @endforeach
                </select>

                <select name="status_id" onchange="this.form.submit()"
                    class="border rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
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
                <span class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors inline-block">
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
            <p class="text-sm text-gray-500 font-medium">Total Sites</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500 font-medium">Active</p>
            <p class="text-3xl font-bold text-green-600 mt-1">{{ $active }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500 font-medium">For Renewal</p>
            <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $forRenewal }}</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow">
            <p class="text-sm text-gray-500 font-medium">Terminated</p>
            <p class="text-3xl font-bold text-red-500 mt-1">{{ $terminated }}</p>
        </div>
    </div>

    {{-- Bar Chart --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-base font-semibold text-gray-700 mb-4">
            {{ $selectedProvince ? 'Sites per municipality' : 'Sites per province' }}
        </h2>
        <canvas id="wifiChart" height="100"></canvas>
    </div>

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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('wifiChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData->pluck('label')),
            datasets: [{
                label: 'Wifi Sites',
                data: @json($chartData->pluck('count')),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                hoverBackgroundColor: '#2563eb'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    padding: 10,
                    cornerRadius: 8
                }
            },
            scales: { 
                y: { 
                    beginAtZero: true, 
                    ticks: { stepSize: 1, font: { size: 11 } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
</script>
@endpush