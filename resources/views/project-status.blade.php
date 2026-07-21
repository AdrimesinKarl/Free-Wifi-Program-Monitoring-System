@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
            FreeWifi Project Status
        </h1>
        <p class="text-slate-500 dark:text-slate-400">
            View and manage all FreeWiFi project locations.
        </p>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm p-5 mb-6">

        <form method="GET"
              action="{{ route('project-status') }}"
              class="flex flex-wrap items-center gap-3">

            {{-- Search --}}
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search site name..."
                class="w-72 rounded-xl border border-slate-300 dark:border-slate-700
                       bg-white dark:bg-slate-900
                       px-4 py-2 text-sm
                       focus:ring-2 focus:ring-violet-500
                       focus:border-violet-500">

            {{-- Province --}}
            <select
                id="province_id"
                name="province_id"
                class="w-64">

                <option value="">All Provinces</option>

                @foreach($provinces as $province)
                    <option
                        value="{{ $province->id }}"
                        {{ request('province_id') == $province->id ? 'selected' : '' }}>
                        {{ $province->name }}
                    </option>
                @endforeach

            </select>

            {{-- Status --}}
            <select
                id="status_id"
                name="status_id"
                class="w-64">

                <option value="">All Statuses</option>

                @foreach($statuses as $status)
                    <option
                        value="{{ $status->id }}"
                        {{ request('status_id') == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach

            </select>

            {{-- Buttons --}}
            <button
                type="submit"
                class="px-5 py-2.5 rounded-xl bg-violet-600 text-white text-sm font-medium
                       hover:bg-violet-700 transition">

                Filter

            </button>

            <a href="{{ route('project-status') }}"
               class="px-5 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700
                      text-sm hover:bg-slate-50 dark:hover:bg-slate-800 transition">

                Reset

            </a>

        </form>

    </div>

    {{-- Table Card --}}
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="font-semibold text-slate-900 dark:text-slate-100">
                Project List
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">#</th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Site Name
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Barangay
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Municipality
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Province
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($locations as $loc)

                        <tr class="border-t border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 transition">

                            <td class="px-6 py-4 text-slate-400">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-900 dark:text-slate-100">
                                {{ $loc->site_name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $loc->barangay }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $loc->municipality->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $loc->municipality->province->name }}
                            </td>

                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex items-center rounded-full px-3 py-1 text-xs font-medium text-white"
                                    style="background: {{ $loc->status->color }}">

                                    {{ $loc->status->name }}

                                </span>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <svg class="w-10 h-10 text-slate-300 mb-3"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="1.5"
                                              d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>

                                    </svg>

                                    <p class="font-medium text-slate-500">
                                        No locations found
                                    </p>

                                    <p class="text-sm text-slate-400 mt-1">
                                        Try adjusting your filters.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $locations->withQueryString()->links() }}
    </div>

</div>

@endsection