@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 600px; border-radius: 12px; }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Province filter --}}
    <form method="GET" action="{{ route('map') }}" class="mb-4">
        <select name="province_id" onchange="this.form.submit()" class="border rounded px-3 py-2 text-sm">
            <option value="">Select Province</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}"
                    {{ $selectedProvince == $province->id ? 'selected' : '' }}>
                    {{ $province->name }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="flex gap-4">
        {{-- Left: location list --}}
        <div class="w-1/3 bg-white rounded-xl border overflow-y-auto" style="max-height:600px">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 sticky top-0">
                    <tr>
                        <th class="text-left px-3 py-2">Site</th>
                        <th class="text-left px-3 py-2">Brgy</th>
                        <th class="text-left px-3 py-2">Municipality</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($locations as $loc)
                    <tr class="border-t hover:bg-gray-50 cursor-pointer"
                        onclick="focusMarker({{ $loc->id }})">
                        <td class="px-3 py-2">{{ $loc->site_name }}</td>
                        <td class="px-3 py-2">{{ $loc->barangay }}</td>
                        <td class="px-3 py-2">{{ $loc->municipality->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-3 py-4 text-center text-gray-400">Select a province</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Right: map --}}
        <div class="flex-1">
            <div id="map"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush