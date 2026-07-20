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
        $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:10240'],
        ]);

        $import = new LocationsImport;

        Excel::import($import, $request->file('csv_file'));

        $failures = $import->failures();

        if ($failures->isNotEmpty()) {
            $errors = $failures->map(fn($f) =>
                "Row {$f->row()}: " . implode(', ', $f->errors())
            )->toArray();

            return back()
                ->with('warning', $failures->count() . ' row(s) skipped due to errors.')
                ->with('import_errors', $errors);
        }

        return back()->with('success', 'All locations imported successfully.');
    }

    public function reset()
    {
        Location::query()->delete();
    
        return redirect()->route('dashboard')->with('success', 'All locations have been reset.');
    }
}