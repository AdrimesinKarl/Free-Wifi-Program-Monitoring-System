<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Region;
use App\Models\Province;
use App\Models\Status;

class ProjectStatusController extends Controller
{
    public function index(Request $request)
    {
        $regions = Region::orderBy('name')->get();

        $statuses = Status::orderBy('name')->get();

        $provinces = Province::orderBy('name')->get();


        $locations = Location::with([
                'municipality.province.region',
                'status'
            ])
            ->when($request->region_id, function ($q) use ($request) {

                $q->whereHas('municipality.province', function ($q) use ($request) {

                    $q->where('region_id', $request->region_id);

                });

            })
            ->when($request->province_id, function ($q) use ($request) {

                $q->whereHas('municipality', function ($q) use ($request) {

                    $q->where('province_id', $request->province_id);

                });

            })
            ->when($request->status_id, function ($q) use ($request) {

                $q->where('status_id', $request->status_id);

            })
            ->when($request->search, function ($q) use ($request) {

                $q->where('site_name', 'like', '%' . $request->search . '%');

            })
            ->orderBy('site_name')
            ->paginate(25);


        return view('project-status', compact(
            'locations',
            'regions',
            'statuses',
            'provinces'
        ));
    }
}