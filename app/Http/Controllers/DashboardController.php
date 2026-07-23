<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Region;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Status;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Selected filters
        $selectedRegion   = $request->integer('region_id');
        $selectedProvince = $request->integer('province_id');
        $selectedStatus   = $request->integer('status_id');

        // Dropdown data
        $regions = Region::orderBy('name')->get();

        $provinces = Province::whereHas('municipalities.locations')
            ->when($selectedRegion, function ($query) use ($selectedRegion) {
                $query->where('region_id', $selectedRegion);
            })
            ->orderBy('name')
            ->get();

        $statuses = Status::orderBy('name')->get();

        // Location query
        $query = Location::query();

        // Region filter
        if ($selectedRegion) {

            $query->whereHas('municipality.province', function ($q) use ($selectedRegion) {
                $q->where('region_id', $selectedRegion);
            });

        }

        // Province filter
        if ($selectedProvince) {

            $query->whereHas('municipality', function ($q) use ($selectedProvince) {
                $q->where('province_id', $selectedProvince);
            });

        }

        // Status filter
        if ($selectedStatus) {

            $query->where('status_id', $selectedStatus);

        }

        // Counters
        $total = (clone $query)->count();

        $active = (clone $query)
            ->whereHas('status', function ($q) {
                $q->where('name', 'Active');
            })
            ->count();

        $forRenewal = (clone $query)
            ->whereHas('status', function ($q) {
                $q->where('name', 'For Renewal');
            })
            ->count();

        $terminated = (clone $query)
            ->whereHas('status', function ($q) {
                $q->where('name', 'Terminated');
            })
            ->count();

        // Chart data
        if ($selectedProvince) {

            $chartData = Municipality::where('province_id', $selectedProvince)
                ->withCount([
                    'locations as count' => function ($q) use ($selectedStatus) {

                        if ($selectedStatus) {
                            $q->where('status_id', $selectedStatus);
                        }

                    }
                ])
                ->orderBy('name')
                ->get()
                ->map(function ($m) {

                    return [
                        'label' => $m->name,
                        'count' => (int) $m->count
                    ];

                })
                ->values();

        } else {

            $chartData = Province::whereHas('municipalities.locations')
                ->when($selectedRegion, function ($query) use ($selectedRegion) {

                    $query->where('region_id', $selectedRegion);

                })
                ->orderBy('name')
                ->get()
                ->map(function ($province) use ($selectedStatus) {

                    $count = Location::whereHas('municipality', function ($q) use ($province) {

                            $q->where('province_id', $province->id);

                        })
                        ->when($selectedStatus, function ($q) use ($selectedStatus) {

                            $q->where('status_id', $selectedStatus);

                        })
                        ->count();

                    return [
                        'label' => $province->name,
                        'count' => (int) $count
                    ];

                })
                ->values();

        }

        return view('dashboard', compact(

            'regions',
            'provinces',
            'statuses',

            'selectedRegion',
            'selectedProvince',
            'selectedStatus',

            'total',
            'active',
            'forRenewal',
            'terminated',

            'chartData'

        ));
    }
}