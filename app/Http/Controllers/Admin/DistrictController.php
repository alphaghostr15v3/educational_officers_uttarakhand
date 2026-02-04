<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Division;

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

        District::create($validated);
        return back()->with('success', 'District established successfully.');
    }

    public function destroy(District $district)
    {
        $district->delete();
        return back()->with('success', 'District removed.');
    }
}
