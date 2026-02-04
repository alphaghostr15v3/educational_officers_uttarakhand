<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Division;
use App\Services\ActivityLogService;

class DistrictController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $districts = District::with('division')->latest()->get();
        $divisions = Division::all();
        return view('admin.districts.index', compact('districts', 'divisions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:districts,code',
        ]);

        $district = District::create($validated);
        ActivityLogService::log('create', "Established new district: {$district->name}", District::class, $district->id);
        return back()->with('success', 'District established successfully.');
    }

    public function update(Request $request, District $district)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'division_id' => 'required|exists:divisions,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:districts,code,' . $district->id,
        ]);

        $district->update($validated);
        ActivityLogService::log('update', "Updated district: {$district->name}", District::class, $district->id);
        return back()->with('success', 'District updated.');
    }

    public function destroy(District $district)
    {
        $name = $district->name;
        $id = $district->id;
        $district->delete();
        ActivityLogService::log('delete', "Removed district: {$name}", District::class, $id);
        return back()->with('success', 'District removed.');
    }
}
