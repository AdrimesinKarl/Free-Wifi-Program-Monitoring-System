@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Filters --}}
    <form method="GET" action="{{ route('dashboard') }}" class="flex gap-4 mb-6">
        <select name="province_id" onchange="this.form.submit()"
            class="border rounded px-3 py-2 text-sm">
            <option value="">All Provinces</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}"
                    {{ $selectedProvince == $province->id ? 'selected' : '' }}>
                    {{ $province->name }}
                </option>
            @endforeach
        </select>

        <select name="status_id" onchange="this.form.submit()"
            class="border rounded px-3 py-2 text-sm">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}"
                    {{ $selectedStatus == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border p-4">
            <p class="text-sm text-gray-500">Total Sites</p>
            <p class="text-3xl font-semibold">{{ $total }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-sm text-gray-500">Active</p>
            <p class="text-3xl font-semibold text-green-600">{{ $active }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-sm text-gray-500">For Renewal</p>
            <p class="text-3xl font-semibold text-yellow-500">{{ $forRenewal }}</p>
        </div>
        <div class="bg-white rounded-xl border p-4">
            <p class="text-sm text-gray-500">Terminated</p>
            <p class="text-3xl font-semibold text-red-500">{{ $terminated }}</p>
        </div>
    </div>

    {{-- Bar Chart --}}
    <div class="bg-white rounded-xl border p-6">
        <h2 class="text-base font-medium mb-4">
            {{ $selectedProvince ? 'Sites per municipality' : 'Sites per province' }}
        </h2>
        <canvas id="wifiChart" height="100"></canvas>
    </div>

</div>

{{-- CSV Upload --}}
<div class="mt-6 bg-white rounded-xl border p-6">
    <h2 class="text-base font-medium mb-4">Import locations</h2>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('locations.upload') }}" enctype="multipart/form-data"
        class="flex items-center gap-3">
        @csrf
        <input type="file" name="csv_file" accept=".csv,.txt" class="text-sm">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">Upload CSV</button>
    </form>

    @error('csv_file')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror

    <form method="POST" action="{{ route('locations.reset') }}" class="mt-4"
        onsubmit="return confirm('Reset all locations? This cannot be undone.')">
        @csrf
        <button type="submit" class="px-4 py-2 border border-red-300 text-red-600 rounded text-sm hover:bg-red-50">
            Reset all locations
        </button>
    </form>
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
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endpush