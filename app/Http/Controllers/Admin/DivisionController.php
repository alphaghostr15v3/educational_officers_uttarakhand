<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Division;

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

        Division::create($validated);
        return back()->with('success', 'Division created successfully.');
    }

    public function destroy(Division $division)
    {
        if ($division->districts()->count() > 0) {
            return back()->with('error', 'Cannot delete division with active districts.');
        }
        $division->delete();
        return back()->with('success', 'Division removed.');
    }
}
