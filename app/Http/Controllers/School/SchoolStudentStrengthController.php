<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\StudentStrength;
use Illuminate\Http\Request;

class SchoolStudentStrengthController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school;
        // Fetch existing records or create defaults if not exist
        $classGroups = ['Class 1-5', 'Class 6-8', 'Class 9-10', 'Class 11-12'];
        $strengths = StudentStrength::where('school_id', $school->id)->get()->keyBy('class_group');
        
        return view('school.students.index', compact('school', 'classGroups', 'strengths'));
    }

    public function update(Request $request)
    {
        $school = auth()->user()->school;
        $data = $request->input('strengths'); // Array of data
        
        foreach ($data as $group => $values) {
            StudentStrength::updateOrCreate(
                ['school_id' => $school->id, 'class_group' => $group],
                [
                    'boys' => $values['boys'] ?? 0,
                    'girls' => $values['girls'] ?? 0,
                    'total' => ($values['boys'] ?? 0) + ($values['girls'] ?? 0),
                    'stream' => $values['stream'] ?? null
                ]
            );
        }
        
        return back()->with('success', 'Student strength updated successfully.');
    }
}
