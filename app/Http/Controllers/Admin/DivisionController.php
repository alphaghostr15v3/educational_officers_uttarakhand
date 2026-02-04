<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;
use App\Services\ActivityLogService;

class DivisionController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $divisions = Division::withCount('districts')->latest()->get();
        return view('admin.divisions.index', compact('divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:divisions,code',
        ]);

        $division = Division::create($validated);
        ActivityLogService::log('create', "Established new division: {$division->name}", Division::class, $division->id);
        return back()->with('success', 'Division created successfully.');
    }

    public function update(Request $request, Division $division)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:divisions,code,' . $division->id,
        ]);

        $division->update($validated);
        ActivityLogService::log('update', "Updated division: {$division->name}", Division::class, $division->id);
        return back()->with('success', 'Division updated.');
    }

    public function destroy(Division $division)
    {
        if ($division->districts()->count() > 0) {
            return back()->with('error', 'Cannot delete division with active districts.');
        }
        $name = $division->name;
        $id = $division->id;
        $division->delete();
        ActivityLogService::log('delete', "Removed division: {$name}", Division::class, $id);
        return back()->with('success', 'Division removed.');
    }
}
