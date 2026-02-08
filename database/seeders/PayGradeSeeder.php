<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PayGrade;

class PayGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 7th Pay Commission Pay Levels for Uttarakhand Government Employees
        
        PayGrade::create([
            'name' => 'Level-1',
            'range' => '18000-56900',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-2',
            'range' => '19900-63200',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-3',
            'range' => '21700-69100',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-4',
            'range' => '25500-81100',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-5',
            'range' => '29200-92300',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-6',
            'range' => '35400-112400',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-7',
            'range' => '44900-142400',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-8',
            'range' => '47600-151100',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-9',
            'range' => '53100-167800',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-10',
            'range' => '56100-177500',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-11',
            'range' => '67700-208700',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-12',
            'range' => '78800-209200',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-13',
            'range' => '118500-214100',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-14',
            'range' => '144200-218200',
            'grade_pay' => null,
            'is_active' => true,
        ]);

        PayGrade::create([
            'name' => 'Level-15',
            'range' => '182200-224100',
            'grade_pay' => null,
            'is_active' => true,
        ]);
    }
}
