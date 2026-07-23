<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Region;
use App\Models\Province;

class MapController extends Controller
{
    public function index(Request $request)
    {
        // Selected filters
        $selectedRegion   = $request->integer('region_id');
        $selectedProvince = $request->integer('province_id');

        // Dropdown data
        $regions = Region::orderBy('name')->get();

        $provinces = Province::when($selectedRegion, function ($query) use ($selectedRegion) {

            $query->where('region_id', $selectedRegion);

        })
        ->orderBy('name')
        ->get();

        // Locations
        $locations = Location::with([
                'municipality.province',
                'status'
            ])

            ->when($selectedRegion, function ($query) use ($selectedRegion) {

                $query->whereHas('municipality.province', function ($q) use ($selectedRegion) {

                    $q->where('region_id', $selectedRegion);

                });

            })

            ->when($selectedProvince, function ($query) use ($selectedProvince) {

                $query->whereHas('municipality', function ($q) use ($selectedProvince) {

                    $q->where('province_id', $selectedProvince);

                });

            })

            ->get();

        return view('map', compact(

            'regions',
            'provinces',

            'selectedRegion',
            'selectedProvince',

            'locations'

        ));
    }
}