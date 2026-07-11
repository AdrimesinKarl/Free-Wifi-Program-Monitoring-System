<?php

namespace Database\Seeders;

use App\Models\Province;
use App\Models\Municipality;
use App\Models\Status;
use App\Models\Location;
use Illuminate\Database\Seeder;

class FreeWifiSeeder extends Seeder
{
    public function run(): void
    {
        // Statuses
        $statuses = [
            ['name' => 'Active',      'color' => '#16a34a'],
            ['name' => 'For Renewal', 'color' => '#d97706'],
            ['name' => 'Terminated',  'color' => '#dc2626'],
            ['name' => 'Pending',     'color' => '#6b7280'],
        ];

        foreach ($statuses as $s) {
            Status::firstOrCreate(['name' => $s['name']], $s);
        }

        $statusNames = ['Active', 'For Renewal', 'Pending', 'Terminated'];

        // Provinces & Data
        $provincesData = [
            'Metro Manila (NCR)',
            'Cebu',
            'Davao del Sur',
            'Misamis Oriental',
            'Aklan',
        ];

        foreach ($provincesData as $provName) {
            $province = Province::firstOrCreate(['name' => $provName]);

            $muns = match($provName) {
                'Metro Manila (NCR)' => ['Mandaluyong', 'Pasay', 'Manila'],
                'Cebu'               => ['Cebu City', 'Lapu-Lapu'],
                'Davao del Sur'      => ['Davao City'],
                'Misamis Oriental'   => ['Cagayan de Oro'],
                'Aklan'              => ['Kalibo'],
                default              => ['Main City'],
            };

            foreach ($muns as $munName) {
                $municipality = Municipality::firstOrCreate([
                    'name'        => $munName,
                    'province_id' => $province->id,
                ]);

                for ($i = 1; $i <= 4; $i++) {
                    $startDate = now()->subMonths(rand(6, 36));

                    Location::create([
                        'site_name'       => "Free WiFi Site {$i} - {$munName}",
                        'barangay'        => 'Brgy ' . rand(1, 30),
                        'municipality_id' => $municipality->id,
                        'status_id'       => Status::where('name', $statusNames[$i - 1])->first()->id,
                        'latitude'        => 14.5 + (rand(-50, 50) / 10),
                        'longitude'       => 121.0 + (rand(-50, 50) / 10),
                        'start_date'   => $startDate->format('Y-m-d'),
                        'renewal_date' => $startDate->copy()->addYear()->format('Y-m-d'),
                    ]);
                }
            }
        }

        $this->command->info('Seeded ' . Location::count() . ' Free WiFi locations successfully!');
    }
}