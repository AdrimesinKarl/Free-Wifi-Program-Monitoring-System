<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Province;

// app/Http/Controllers/MapController.php
class MapController extends Controller
{
    public function index(Request $request)
    {
        $provinces        = Province::orderBy('name')->get();
        $selectedProvince = $request->integer('province_id');

        $locations = Location::with(['municipality.province', 'status'])
            ->when($selectedProvince, fn($q) => $q->whereHas('municipality', fn($q) =>
                $q->where('province_id', $selectedProvince)
            ))
            ->get();

        return view('map', compact('provinces', 'selectedProvince', 'locations'));
    }
}