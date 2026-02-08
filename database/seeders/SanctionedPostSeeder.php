<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanctionedPost;
use App\Models\Designation;
use App\Models\School;
use App\Models\District;
use App\Models\Division;

class SanctionedPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some sample schools (first 10)
        $schools = School::limit(10)->get();
        
        // Get designations
        $principal = Designation::where('name', 'Principal')->first();
        $vicePrincipal = Designation::where('name', 'Vice Principal')->first();
        $pgt = Designation::where('name', 'LIKE', '%PGT%')->first();
        $tgt = Designation::where('name', 'LIKE', '%TGT%')->first();
        $prt = Designation::where('name', 'LIKE', '%PRT%')->first();
        $librarian = Designation::where('name', 'Librarian')->first();
        $labAssistant = Designation::where('name', 'Lab Assistant')->first();
        $peon = Designation::where('name', 'Peon')->first();

        // Create sanctioned posts for each school
        foreach ($schools as $school) {
            // Principal - 1 post
            if ($principal) {
                SanctionedPost::create([
                    'designation_id' => $principal->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 1,
                    'is_active' => true,
                ]);
            }

            // Vice Principal - 1 post
            if ($vicePrincipal) {
                SanctionedPost::create([
                    'designation_id' => $vicePrincipal->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 1,
                    'is_active' => true,
                ]);
            }

            // PGT - 5 posts
            if ($pgt) {
                SanctionedPost::create([
                    'designation_id' => $pgt->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 5,
                    'is_active' => true,
                ]);
            }

            // TGT - 8 posts
            if ($tgt) {
                SanctionedPost::create([
                    'designation_id' => $tgt->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 8,
                    'is_active' => true,
                ]);
            }

            // PRT - 10 posts
            if ($prt) {
                SanctionedPost::create([
                    'designation_id' => $prt->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 10,
                    'is_active' => true,
                ]);
            }

            // Librarian - 1 post
            if ($librarian) {
                SanctionedPost::create([
                    'designation_id' => $librarian->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 1,
                    'is_active' => true,
                ]);
            }

            // Lab Assistant - 2 posts
            if ($labAssistant) {
                SanctionedPost::create([
                    'designation_id' => $labAssistant->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 2,
                    'is_active' => true,
                ]);
            }

            // Peon - 3 posts
            if ($peon) {
                SanctionedPost::create([
                    'designation_id' => $peon->id,
                    'level' => 'school',
                    'school_id' => $school->id,
                    'district_id' => null,
                    'division_id' => null,
                    'sanctioned_count' => 3,
                    'is_active' => true,
                ]);
            }
        }

        // Add some district level posts
        $districts = District::limit(3)->get();
        $deo = Designation::where('name', 'LIKE', '%District Education Officer%')->first();
        $seniorClerk = Designation::where('name', 'Senior Clerk')->first();
        $juniorClerk = Designation::where('name', 'Junior Clerk')->first();

        foreach ($districts as $district) {
            if ($deo) {
                SanctionedPost::create([
                    'designation_id' => $deo->id,
                    'level' => 'district',
                    'school_id' => null,
                    'district_id' => $district->id,
                    'division_id' => null,
                    'sanctioned_count' => 1,
                    'is_active' => true,
                ]);
            }

            if ($seniorClerk) {
                SanctionedPost::create([
                    'designation_id' => $seniorClerk->id,
                    'level' => 'district',
                    'school_id' => null,
                    'district_id' => $district->id,
                    'division_id' => null,
                    'sanctioned_count' => 2,
                    'is_active' => true,
                ]);
            }

            if ($juniorClerk) {
                SanctionedPost::create([
                    'designation_id' => $juniorClerk->id,
                    'level' => 'district',
                    'school_id' => null,
                    'district_id' => $district->id,
                    'division_id' => null,
                    'sanctioned_count' => 5,
                    'is_active' => true,
                ]);
            }
        }
    }
}
