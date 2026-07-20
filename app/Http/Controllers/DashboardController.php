<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Status;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $provinces = Province::whereHas('municipalities.locations')
            ->orderBy('name')
            ->get();

        $statuses = Status::orderBy('name')->get();

        $selectedProvince = $request->integer('province_id');
        $selectedStatus   = $request->integer('status_id');

        // Base query with optional filters
        $query = Location::query();

        if ($selectedProvince) {
            $query->whereHas('municipality', fn($q) => $q->where('province_id', $selectedProvince));
        }

        if ($selectedStatus) {
            $query->where('status_id', $selectedStatus);
        }

        $total      = (clone $query)->count();
        $active     = (clone $query)->whereHas('status', fn($q) => $q->where('name', 'Active'))->count();
        $forRenewal = (clone $query)->whereHas('status', fn($q) => $q->where('name', 'For Renewal'))->count();
        $terminated = (clone $query)->whereHas('status', fn($q) => $q->where('name', 'Terminated'))->count();

        // Chart data — cast counts to int so JSON always gets numbers, never null
        if ($selectedProvince) {
            $chartData = Municipality::where('province_id', $selectedProvince)
                ->withCount(['locations as count' => function ($q) use ($selectedStatus) {
                    if ($selectedStatus) {
                        $q->where('status_id', $selectedStatus);
                    }
                }])
                ->get()
                ->map(fn($m) => ['label' => $m->name, 'count' => (int) $m->count])
                ->values(); // reset keys → clean JSON array
        } else {
            $chartData = Province::whereHas('municipalities.locations') // skip empty provinces
                ->orderBy('name')
                ->get()
                ->map(function ($p) use ($selectedStatus) {
                    $count = Location::whereHas('municipality', fn($q) => $q->where('province_id', $p->id))
                        ->when($selectedStatus, fn($q) => $q->where('status_id', $selectedStatus))
                        ->count();

                    return ['label' => $p->name, 'count' => (int) $count];
                })
                ->values(); // reset keys → clean JSON array
        }

        return view('dashboard', compact(
            'provinces',
            'statuses',
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