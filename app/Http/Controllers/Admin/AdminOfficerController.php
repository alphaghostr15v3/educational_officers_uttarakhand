<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Officer;
use App\Models\District;
use App\Models\Division;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogService;

class AdminOfficerController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Officer::with(['district', 'division']);

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        }

        $officers = $query->latest()->paginate(10);
        return view('admin.officers.index', compact('officers'));
    }

    public function create()
    {
        $user = auth()->user();
        $divisions = Division::all();
        $districts = District::query();

        if ($user->role === 'division_admin') {
            $districts->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $districts->where('id', $user->district_id);
        }

        $districts = $districts->get();
        return view('admin.officers.create', compact('divisions', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'employee_code' => 'required|string|unique:officers,employee_code',
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'email' => 'nullable|email|unique:officers,email',
            'mobile' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('officers', 'public');
        }

        $officer = Officer::create($validated);

        ActivityLogService::log('create', "Added new officer: {$officer->name}", Officer::class, $officer->id);

        return redirect()->route('admin.officers.index')->with('success', 'Officer added successfully.');
    }

    public function edit(Officer $officer)
    {
        $this->authorizeAccess($officer);
        
        $user = auth()->user();
        $divisions = Division::all();
        $districts = District::query();

        if ($user->role === 'division_admin') {
            $districts->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $districts->where('id', $user->district_id);
        }

        $districts = $districts->get();
        return view('admin.officers.edit', compact('officer', 'divisions', 'districts'));
    }

    public function update(Request $request, Officer $officer)
    {
        $this->authorizeAccess($officer);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'employee_code' => 'required|string|unique:officers,employee_code,' . $officer->id,
            'division_id' => 'required|exists:divisions,id',
            'district_id' => 'required|exists:districts,id',
            'email' => 'nullable|email|unique:officers,email,' . $officer->id,
            'mobile' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($officer->photo) {
                Storage::disk('public')->delete($officer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('officers', 'public');
        }

        $officer->update($validated);

        ActivityLogService::log('update', "Updated officer details: {$officer->name}", Officer::class, $officer->id);

        return redirect()->route('admin.officers.index')->with('success', 'Officer updated successfully.');
    }

    public function destroy(Officer $officer)
    {
        $this->authorizeAccess($officer);
        
        if ($officer->photo) {
            Storage::disk('public')->delete($officer->photo);
        }
        
        $name = $officer->name;
        $id = $officer->id;
        $officer->delete();

        ActivityLogService::log('delete', "Removed officer: {$name}", Officer::class, $id);

        return redirect()->route('admin.officers.index')->with('success', 'Officer deleted successfully.');
    }

    private function authorizeAccess(Officer $officer)
    {
        $user = auth()->user();
        if ($user->role === 'division_admin' && $officer->division_id !== $user->division_id) {
            abort(403);
        }
        if ($user->role === 'district_admin' && $officer->district_id !== $user->district_id) {
            abort(403);
        }
    }
}
