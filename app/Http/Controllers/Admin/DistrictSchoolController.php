<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class DistrictSchoolController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ensure only district/state/division admins can access
        if (!in_array($user->role, ['district_admin', 'division_admin', 'state_admin'])) {
            abort(403, 'Unauthorized access');
        }

        $query = School::query();

        if ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        } elseif ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id);
        }

        $schools = $query->with(['division', 'district'])->latest()->paginate(20);

        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        $user = auth()->user();
        $districts = [];
        
        if ($user->role === 'state_admin') {
            $districts = District::all();
        } elseif ($user->role === 'division_admin') {
            $districts = District::where('division_id', $user->division_id)->get();
        }
        
        return view('admin.schools.create', compact('districts'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $rules = [
            'name' => 'required|string|max:255',
            'udise_code' => 'nullable|string|max:50|unique:schools',
            'block' => 'required|string|max:100',
            'type' => 'required|in:primary,junior_high,secondary,senior_secondary,office',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ];

        // Superior admins must select a district
        if (in_array($user->role, ['state_admin', 'division_admin'])) {
            $rules['district_id'] = 'required|exists:districts,id';
        }

        $validated = $request->validate($rules);

        if ($user->role === 'district_admin') {
            $validated['district_id'] = $user->district_id;
            $validated['division_id'] = $user->division_id; 
        } else {
            // For state/division admin, use the selected district's division
            $district = District::find($validated['district_id']);
            $validated['division_id'] = $district->division_id;
        }

        School::create($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School added successfully.');
    }

    public function show(School $school)
    {
        $user = auth()->user();
        if ($user->role === 'district_admin' && $school->district_id !== $user->district_id) {
            abort(403);
        } elseif ($user->role === 'division_admin' && $school->division_id !== $user->division_id) {
            abort(403);
        }

        $school->load(['division', 'district', 'staffs.user']);
        return view('admin.schools.show', compact('school'));
    }

    public function edit(School $school)
    {
        $user = auth()->user();
        if ($user->role === 'district_admin' && $school->district_id !== $user->district_id) {
            abort(403);
        }

        $districts = [];
        if ($user->role === 'state_admin') {
            $districts = District::all();
        } elseif ($user->role === 'division_admin') {
            $districts = District::where('division_id', $user->division_id)->get();
        }

        return view('admin.schools.create', compact('school', 'districts'));
    }

    public function update(Request $request, School $school)
    {
        $user = auth()->user();
        if ($user->role === 'district_admin' && $school->district_id !== $user->district_id) {
            abort(403);
        }

        $rules = [
            'name' => 'required|string|max:255',
            'udise_code' => 'nullable|string|max:50|unique:schools,udise_code,' . $school->id,
            'block' => 'required|string|max:100',
            'type' => 'required|in:primary,junior_high,secondary,senior_secondary,office',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'is_active' => 'required|boolean',
        ];

        if (in_array($user->role, ['state_admin', 'division_admin'])) {
            $rules['district_id'] = 'required|exists:districts,id';
        }

        $validated = $request->validate($rules);

        if ($user->role === 'district_admin') {
            $validated['district_id'] = $user->district_id;
            $validated['division_id'] = $user->division_id;
        } else if (isset($validated['district_id'])) {
            $district = District::find($validated['district_id']);
            $validated['division_id'] = $district->division_id;
        }

        $school->update($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School updated successfully.');
    }

    public function destroy(School $school)
    {
        $user = auth()->user();
        if ($user->role !== 'state_admin' && $user->role !== 'division_admin' && 
           ($user->role === 'district_admin' && $school->district_id !== $user->district_id)) {
            abort(403);
        }

        $name = $school->name;
        $school->delete();

        return redirect()->route('admin.schools.index')->with('success', "School '{$name}' removed successfully.");
    }
}
