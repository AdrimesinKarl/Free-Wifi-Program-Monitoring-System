<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LocationsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Location;

class LocationImportController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(['csv_file' => 'required|file|mimes:csv,txt|max:10240']);

        Excel::import(new LocationsImport, $request->file('csv_file'));

        return back()->with('success', 'Locations imported successfully.');
    }

    public function reset()
    {
        Location::truncate();
        return back()->with('success', 'All locations have been reset.');
    }
}