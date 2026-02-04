<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\District;

class DivisionDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Garhwal',
                'code' => 'GRH',
                'districts' => [
                    ['name' => 'Dehradun', 'code' => 'DDN'],
                    ['name' => 'Haridwar', 'code' => 'HRW'],
                    ['name' => 'Tehri Garhwal', 'code' => 'TEH'],
                    ['name' => 'Uttarkashi', 'code' => 'UTK'],
                    ['name' => 'Chamoli', 'code' => 'CHM'],
                    ['name' => 'Pauri Garhwal', 'code' => 'PAU'],
                    ['name' => 'Rudraprayag', 'code' => 'RUD'],
                ]
            ],
            [
                'name' => 'Kumaon',
                'code' => 'KUM',
                'districts' => [
                    ['name' => 'Nainital', 'code' => 'NAI'],
                    ['name' => 'Almora', 'code' => 'ALM'],
                    ['name' => 'Pithoragarh', 'code' => 'PIT'],
                    ['name' => 'Champawat', 'code' => 'CHP'],
                    ['name' => 'Bageshwar', 'code' => 'BAG'],
                    ['name' => 'Udham Singh Nagar', 'code' => 'USN'],
                ]
            ],
        ];

        foreach ($divisions as $divData) {
            $division = Division::create([
                'name' => $divData['name'],
                'code' => $divData['code'],
            ]);

            foreach ($divData['districts'] as $distData) {
                District::create([
                    'division_id' => $division->id,
                    'name' => $distData['name'],
                    'code' => $distData['code'],
                ]);
            }
        }
    }
}
