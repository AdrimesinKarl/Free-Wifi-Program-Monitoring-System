@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Filters --}}
    <form method="GET" action="{{ route('project-status') }}" class="flex gap-3 mb-6 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Search site name..."
            class="border rounded px-3 py-2 text-sm w-56">
        
        <select name="province_id" class="border rounded px-3 py-2 text-sm">
            <option value="">All Provinces</option>
            @foreach($provinces as $province)
                <option value="{{ $province->id }}"
                    {{ request('province_id') == $province->id ? 'selected' : '' }}>
                    {{ $province->name }}
                </option>
            @endforeach
        </select>

        <select name="status_id" class="border rounded px-3 py-2 text-sm">
            <option value="">All Statuses</option>
            @foreach($statuses as $status)
                <option value="{{ $status->id }}"
                    {{ request('status_id') == $status->id ? 'selected' : '' }}>
                    {{ $status->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="px-4 py-2 bg-e-600 text-white rounded text-sm">Filter</button>
        <a href="{{ route('project-status') }}" class="px-4 py-2 border rounded text-sm">Clear Search</a>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Site Name</th>
                    <th class="text-left px-4 py-3">Barangay</th>
                    <th class="text-left px-4 py-3">Municipality</th>
                    <th class="text-left px-4 py-3">Province</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Start Date</th>
                    <th class="text-left px-4 py-3">Renewal Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($locations as $loc)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 font-medium">{{ $loc->site_name }}</td>
                        <td class="px-4 py-3">{{ $loc->barangay }}</td>
                        <td class="px-4 py-3">{{ $loc->municipality->name }}</td>
                        <td class="px-4 py-3">{{ $loc->municipality->province->name }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded-full text-xs text-white"
                                style="background-color: {{ $loc->status->color }}">
                                {{ $loc->status->name }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $loc->start_date?->format('M d, Y') ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $loc->renewal_date?->format('M d, Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-500">No results found</p>
                                @if(request()->hasAny(['search', 'province_id', 'status_id']))
                                    <p class="text-xs text-gray-400">Try adjusting your search or filter</p>
                                    <a href="{{ route('project-status') }}" class="mt-1 text-xs text-blue-500 hover:underline">Clear filters</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $locations->withQueryString()->links() }}
    </div>
</div>
@endsection