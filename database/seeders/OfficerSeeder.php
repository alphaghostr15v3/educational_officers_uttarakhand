<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Officer;
use App\Models\District;
use App\Models\Division;

class OfficerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $officers = [
            [
                'name' => 'Rajesh Sharma',
                'designation' => 'Senior Assistant',
                'employee_code' => 'UK-EDU-1001',
                'district_id' => 1, // Dehradun
                'division_id' => 1, // Garhwal
                'email' => 'rajesh.sharma@uk.gov.in',
            ],
            [
                'name' => 'Meena Negi',
                'designation' => 'Administrative Officer',
                'employee_code' => 'UK-EDU-1002',
                'district_id' => 2, // Haridwar
                'division_id' => 1,
                'email' => 'meena.negi@uk.gov.in',
            ],
            [
                'name' => 'Sanjay Rawat',
                'designation' => 'Junior Assistant',
                'employee_code' => 'UK-EDU-1003',
                'district_id' => 8, // Nainital
                'division_id' => 2, // Kumaon
                'email' => 'sanjay.rawat@uk.gov.in',
            ],
            [
                'name' => 'Anita Bisht',
                'designation' => 'Chief Administrative Officer',
                'employee_code' => 'UK-EDU-1004',
                'district_id' => 9, // Almora
                'division_id' => 2,
                'email' => 'anita.bisht@uk.gov.in',
            ],
            [
                'name' => 'Vijay Bhatt',
                'designation' => 'Senior Assistant',
                'employee_code' => 'UK-EDU-1005',
                'district_id' => 1,
                'division_id' => 1,
                'email' => 'vijay.bhatt@uk.gov.in',
            ],
        ];

        foreach ($officers as $officerData) {
            Officer::create($officerData);
        }
    }
}
