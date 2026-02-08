<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // State Level Designations
        $stateSecretary = Designation::create([
            'name' => 'State Education Secretary',
            'level' => 'state',
            'parent_id' => null,
            'order' => 1,
            'is_active' => true,
        ]);

        $additionalSecretary = Designation::create([
            'name' => 'Additional Secretary',
            'level' => 'state',
            'parent_id' => $stateSecretary->id,
            'order' => 2,
            'is_active' => true,
        ]);

        // Division Level Designations
        $divisionEducationOfficer = Designation::create([
            'name' => 'Divisional Education Officer',
            'level' => 'division',
            'parent_id' => $additionalSecretary->id,
            'order' => 3,
            'is_active' => true,
        ]);

        $assistantDEO = Designation::create([
            'name' => 'Assistant Divisional Education Officer',
            'level' => 'division',
            'parent_id' => $divisionEducationOfficer->id,
            'order' => 4,
            'is_active' => true,
        ]);

        // District Level Designations
        $districtEducationOfficer = Designation::create([
            'name' => 'District Education Officer',
            'level' => 'district',
            'parent_id' => $divisionEducationOfficer->id,
            'order' => 5,
            'is_active' => true,
        ]);

        $assistantDEODistrict = Designation::create([
            'name' => 'Assistant District Education Officer',
            'level' => 'district',
            'parent_id' => $districtEducationOfficer->id,
            'order' => 6,
            'is_active' => true,
        ]);

        $seniorClerk = Designation::create([
            'name' => 'Senior Clerk',
            'level' => 'district',
            'parent_id' => null,
            'order' => 7,
            'is_active' => true,
        ]);

        $juniorClerk = Designation::create([
            'name' => 'Junior Clerk',
            'level' => 'district',
            'parent_id' => $seniorClerk->id,
            'order' => 8,
            'is_active' => true,
        ]);

        // School Level Designations
        $principal = Designation::create([
            'name' => 'Principal',
            'level' => 'school',
            'parent_id' => null,
            'order' => 9,
            'is_active' => true,
        ]);

        $vicePrincipal = Designation::create([
            'name' => 'Vice Principal',
            'level' => 'school',
            'parent_id' => $principal->id,
            'order' => 10,
            'is_active' => true,
        ]);

        $headmaster = Designation::create([
            'name' => 'Headmaster',
            'level' => 'school',
            'parent_id' => null,
            'order' => 11,
            'is_active' => true,
        ]);

        $assistantHeadmaster = Designation::create([
            'name' => 'Assistant Headmaster',
            'level' => 'school',
            'parent_id' => $headmaster->id,
            'order' => 12,
            'is_active' => true,
        ]);

        $pgt = Designation::create([
            'name' => 'Post Graduate Teacher (PGT)',
            'level' => 'school',
            'parent_id' => null,
            'order' => 13,
            'is_active' => true,
        ]);

        $tgt = Designation::create([
            'name' => 'Trained Graduate Teacher (TGT)',
            'level' => 'school',
            'parent_id' => $pgt->id,
            'order' => 14,
            'is_active' => true,
        ]);

        $prt = Designation::create([
            'name' => 'Primary Teacher (PRT)',
            'level' => 'school',
            'parent_id' => $tgt->id,
            'order' => 15,
            'is_active' => true,
        ]);

        $librarian = Designation::create([
            'name' => 'Librarian',
            'level' => 'school',
            'parent_id' => null,
            'order' => 16,
            'is_active' => true,
        ]);

        $labAssistant = Designation::create([
            'name' => 'Lab Assistant',
            'level' => 'school',
            'parent_id' => null,
            'order' => 17,
            'is_active' => true,
        ]);

        $peon = Designation::create([
            'name' => 'Peon',
            'level' => 'school',
            'parent_id' => null,
            'order' => 18,
            'is_active' => true,
        ]);
    }
}
