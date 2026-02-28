<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'stateadmin@uk.gov.in'],
            [
                'name' => 'State Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'state_admin',
                'is_active' => true,
            ]
        );
    }
}
