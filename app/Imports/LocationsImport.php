<?php

namespace App\Imports;

use App\Models\Location;
use App\Models\Region;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\Status;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class LocationsImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsFailures;

    protected $statuses;

    protected array $regionCache       = [];
    protected array $provinceCache     = [];
    protected array $municipalityCache = [];

    public function __construct()
    {
        $this->statuses = Status::all()->keyBy(fn($s) => strtolower(trim($s->name)));
    }

    public function model(array $row): Location
    {
        $status       = $this->statuses->get(strtolower(trim($row['status'])));
        $region       = $this->resolveRegion($row['region']);
        $province     = $this->resolveProvince($row['province'], $region->id);
        $municipality = $this->resolveMunicipality($row['municipality'], $province->id);

        return Location::updateOrCreate(
            ['site_name' => $row['site_name']],
            [
                'barangay'        => $row['barangay'],
                'municipality_id' => $municipality->id,
                'status_id'       => $status->id,
                'latitude'        => $row['latitude']     ?? null,
                'longitude'       => $row['longitude']    ?? null,
                //'start_date'      => $row['start_date']   ?? null,
                //'renewal_date'    => $row['renewal_date'] ?? null,
            ]
        );
    }

    // Regions are geographic reference data — fine to create from CSV
    protected function resolveRegion(string $name): Region
    {
        $key = strtolower(trim($name));

        return $this->regionCache[$key] ??= Region::firstOrCreate(
            ['name' => trim($name)]
        );
    }
    // Provinces are geographic reference data — fine to create from CSV
    protected function resolveProvince(string $name, int $regionId): Province
    {
        $key = strtolower(trim($name)) . '|' . $regionId; // ← scoped to region

        return $this->provinceCache[$key] ??= Province::firstOrCreate(
            ['name' => trim($name), 'region_id' => $regionId]
        );
    }

    // Every municipality must belong to a province (DB requires province_id) -
    // resolve it scoped to that province, not just by name alone
    protected function resolveMunicipality(string $name, int $provinceId): Municipality
    {
        $key = strtolower(trim($name)) . '|' . $provinceId;

        return $this->municipalityCache[$key] ??= Municipality::firstOrCreate(
            ['name' => trim($name), 'province_id' => $provinceId]
        );
    }

    public function rules(): array
    {
        return [
            'region'    => ['required', 'string'],
            'site_name' => ['required', 'string', 'max:255'],
            'province'      => ['required', 'string'],
            'municipality'  => ['required', 'string'],
            'barangay'      => ['required', 'string'],
            'status'        => ['required', 'string', function ($attribute, $value, $fail) {
                if (!$this->statuses->has(strtolower(trim($value)))) {
                    $valid = $this->statuses->keys()->join(', ');
                    $fail("Status \"{$value}\" is not recognised. Allowed: {$valid}.");
                }
            }],
            'latitude'  => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'region.required'        => 'Region is missing.',
            'site_name.required'     => 'site_name is missing.',
            'province.required'      => 'Province is missing.',
            'latitude.between'       => 'Latitude must be between -90 and 90.',
            'longitude.between'      => 'Longitude must be between -180 and 180.',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }
}