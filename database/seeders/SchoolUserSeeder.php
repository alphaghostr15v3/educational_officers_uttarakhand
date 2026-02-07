<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SchoolUserSeeder extends Seeder
{
    public function run()
    {
        try {
            DB::beginTransaction();

            $division = Division::first();
            if (!$division) {
                 $division = Division::create(['name' => 'Garhwal']);
            }
            
            $district = District::first();
            if (!$district) {
                 $district = District::create(['name' => 'Dehradun', 'division_id' => $division->id]);
            }

            $school = School::firstOrCreate(
                ['udise_code' => 'TESTSCHOOL001'],
                [
                    'name' => 'Govt. Inter College Dehradun',
                    'district_id' => $district->id,
                    'division_id' => $division->id,
                    'block' => 'Raipur',
                    'address' => 'Dehradun City',
                    'email' => 'gic.dehradun@example.com',
                    'phone' => '9876543210',
                    'type' => 'Secondary',
                    'is_active' => true,
                ]
            );

            // Ensure constraints allow this. If school_id on users table is not yet migrated, this might fail, but migration was run.
            $user = User::updateOrCreate(
                ['email' => 'school@admin.com'],
                [
                    'name' => 'School Clerk',
                    'password' => Hash::make('password'),
                    'role' => 'school',
                    'school_id' => $school->id,
                    'mobile' => '9999999999',
                    'is_active' => true,
                ]
            );
            
            DB::commit();
            $this->command->info('School User Created: school@admin.com / password');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Error: ' . $e->getMessage());
        }
    }
}
