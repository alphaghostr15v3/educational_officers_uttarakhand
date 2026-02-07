<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class DistrictAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $district = District::where('name', 'Dehradun')->first() ?? District::first();
        
        if (!$district) {
            $this->command->error("No districts found. Please seed districts first.");
            return;
        }

        $email = 'district@admin.com';
        
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'District Admin (' . $district->name . ')',
                'password' => Hash::make('password'),
                'role' => 'district_admin',
                'district_id' => $district->id,
                'division_id' => $district->division_id,
                'mobile' => '9876543210',
                'is_active' => true,
            ]
        );

        $this->command->info("District Admin updated: {$email} / password");
    }
}
