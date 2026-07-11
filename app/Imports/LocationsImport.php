<?php

namespace App\Imports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Status;

class LocationsImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row): Location
    {
        $province     = Province::firstOrCreate(['name' => $row['province']]);
        $municipality = Municipality::firstOrCreate(
            ['name' => $row['municipality'], 'province_id' => $province->id]
        );
        $status = Status::firstOrCreate(['name' => $row['status']]);

        return new Location([
            'site_name'       => $row['site_name'],
            'barangay'        => $row['barangay'],,
            'municipality_id' => $municipality->id,
            'status_id'       => $status->id,
            'latitude'        => $row['latitude']  ?? null,
            'longitude'       => $row['longitude'] ?? null,
            'start_date'      => $row['start_date']   ?? null,
            'renewal_date'    => $row['renewal_date'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'site_name'    => 'required|string',
            'barangay'     => 'required|string',
            'municipality' => 'required|string',
            'province'     => 'required|string',
            'status'       => 'required|string',
        ];
    }
}

