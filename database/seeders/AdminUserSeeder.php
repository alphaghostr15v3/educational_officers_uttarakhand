<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // State Admin
        User::create([
            'name' => 'State Admin',
            'email' => 'admin@uk.gov.in',
            'password' => Hash::make('password'),
            'role' => 'state_admin',
            'employee_code' => 'UK-ADMIN-001',
            'is_active' => true,
        ]);

        // Sample Division Admin (Garhwal)
        User::create([
            'name' => 'Garhwal Admin',
            'email' => 'garhwal@uk.gov.in',
            'password' => Hash::make('password'),
            'role' => 'division_admin',
            'division_id' => 1, // Garhwal
            'employee_code' => 'UK-DIV-001',
            'is_active' => true,
        ]);

        // Sample District Admin (Dehradun)
        User::create([
            'name' => 'Dehradun Admin',
            'email' => 'dehradun@uk.gov.in',
            'password' => Hash::make('password'),
            'role' => 'district_admin',
            'division_id' => 1,
            'district_id' => 1, // Dehradun
            'employee_code' => 'UK-DIST-001',
            'is_active' => true,
        ]);
    }
}
