<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Province;
use App\Models\Status;

class ProjectStatusController extends Controller
{
    public function index(Request $request)
    {
        $statuses  = Status::orderBy('name')->get();
        $provinces = Province::orderBy('name')->get();

        $locations = Location::with(['municipality.province', 'status'])
            ->when($request->status_id, fn($q) => $q->where('status_id', $request->status_id))
            ->when($request->province_id, fn($q) => $q->whereHas('municipality',
                fn($q) => $q->where('province_id', $request->province_id)
            ))
            ->when($request->search, fn($q) => $q->where('site_name', 'like', '%'.$request->search.'%'))
            ->orderBy('site_name')
            ->paginate(25);

        return view('project-status', compact('locations', 'statuses', 'provinces'));
    }
}

