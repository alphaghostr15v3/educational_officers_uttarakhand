<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfrastructure;
use Illuminate\Http\Request;

class SchoolInfrastructureController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school;
        $infra = SchoolInfrastructure::firstOrCreate(['school_id' => $school->id]);
        
        return view('school.infrastructure.index', compact('school', 'infra'));
    }

    public function update(Request $request)
    {
        $school = auth()->user()->school;
        
        $validated = $request->validate([
            'classrooms' => 'required|integer|min:0',
            'toilets_boys' => 'required|integer|min:0',
            'toilets_girls' => 'required|integer|min:0',
            'computers' => 'required|integer|min:0',
            // Booleans
            'drinking_water' => 'boolean',
            'electricity' => 'boolean',
            'library' => 'boolean',
            'playground' => 'boolean',
            'smart_class' => 'boolean',
        ]);
        
        // Handle checkboxes not present in request implies false
        $booleans = ['drinking_water', 'electricity', 'library', 'playground', 'smart_class'];
        foreach ($booleans as $field) {
            $validated[$field] = $request->has($field);
        }

        SchoolInfrastructure::updateOrCreate(
            ['school_id' => $school->id],
            $validated
        );

        return back()->with('success', 'Infrastructure details updated successfully.');
    }
}
