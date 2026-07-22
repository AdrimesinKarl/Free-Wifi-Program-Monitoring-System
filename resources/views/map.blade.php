@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto">


    {{-- Page Header --}}
    <div class="mb-6">

        <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
            Location Mapping
        </h1>

        <p class="text-slate-500 dark:text-slate-400">
            View FreeWiFi locations on an interactive map.
        </p>

    </div>



    {{-- Filters --}}
    <form method="GET"
          action="{{ route('map') }}"
          class="flex flex-wrap items-center gap-3 mb-6">


        {{-- Region --}}
        <select
            id="region_id"
            name="region_id"
            class="w-64">


            <option value="">
                All Regions
            </option>


            @foreach($regions as $region)

                <option
                    value="{{ $region->id }}"
                    {{ $selectedRegion == $region->id ? 'selected' : '' }}>

                    {{ $region->name }}

                </option>

            @endforeach


        </select>




        {{-- Province --}}
        <select
            id="map_province_id"
            name="province_id"
            class="w-64">


            <option value="">
                All Provinces
            </option>


            @foreach($provinces as $province)

                <option
                    value="{{ $province->id }}"
                    {{ $selectedProvince == $province->id ? 'selected' : '' }}>

                    {{ $province->name }}

                </option>

            @endforeach


        </select>


    </form>





    {{-- Content --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">



        {{-- Location List --}}
        <div class="
            bg-white dark:bg-slate-900
            rounded-2xl
            border border-slate-200 dark:border-slate-800
            shadow-sm
            overflow-hidden">


            <div class="
                px-5 py-4
                border-b border-slate-200 dark:border-slate-800">


                <h2 class="font-semibold text-slate-900 dark:text-slate-100">
                    Locations
                </h2>


                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ count($locations) }} sites found
                </p>


            </div>




            <div class="overflow-y-auto"
                 style="max-height:520px">


                <table class="w-full text-sm">


                    <thead class="bg-slate-50 dark:bg-slate-800 sticky top-0">


                        <tr>

                            <th class="px-4 py-3 text-left text-slate-600 dark:text-slate-300">
                                Site
                            </th>


                            <th class="px-4 py-3 text-left text-slate-600 dark:text-slate-300">
                                Barangay
                            </th>


                            <th class="px-4 py-3 text-left text-slate-600 dark:text-slate-300">
                                Municipality
                            </th>

                        </tr>


                    </thead>



                    <tbody>


                    @forelse($locations as $loc)


                        <tr

                            data-location-row="{{ $loc->id }}"

                            onclick="focusMarker({{ $loc->id }})"

                            class="
                            border-t border-slate-100
                            dark:border-slate-800
                            hover:bg-slate-50
                            dark:hover:bg-slate-800
                            cursor-pointer
                            transition">


                            <td class="
                                px-4 py-3
                                font-medium
                                text-slate-900
                                dark:text-slate-100">

                                {{ $loc->site_name }}

                            </td>



                            <td class="
                                px-4 py-3
                                text-slate-600
                                dark:text-slate-400">

                                {{ $loc->barangay }}

                            </td>



                            <td class="
                                px-4 py-3
                                text-slate-600
                                dark:text-slate-400">

                                {{ $loc->municipality->name }}

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="3"
                                class="px-4 py-12 text-center text-slate-400">

                                No locations found.

                            </td>


                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>


        </div>





        {{-- Map --}}
        <div class="lg:col-span-2">


            <div class="
                bg-white
                dark:bg-slate-900
                rounded-2xl
                border border-slate-200
                dark:border-slate-800
                shadow-sm
                overflow-hidden">


                {{-- Map Header --}}
                <div class="
                    px-5 py-4
                    border-b border-slate-200
                    dark:border-slate-800
                    flex items-center justify-between">


                    <div>


                        <h2 class="
                            font-semibold
                            text-slate-900
                            dark:text-slate-100">

                            Map View

                        </h2>


                        <p class="
                            text-sm
                            text-slate-500
                            dark:text-slate-400">

                            Click a location to view details.

                        </p>


                    </div>



                    <button

                        id="resetMap"

                        type="button"

                        class="
                        px-3 py-2
                        text-sm
                        rounded-lg
                        border border-slate-300
                        dark:border-slate-700
                        hover:bg-slate-100
                        dark:hover:bg-slate-800
                        transition">


                        Reset View


                    </button>


                </div>





                {{-- Map Container --}}
                <div
                    id="map"
                    class="h-[400px] sm:h-[500px] lg:h-[600px]"
                    data-locations='@json($locations)'>
                </div>



            </div>


        </div>



    </div>


</div>


@endsection