<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class AdminDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $designations = Designation::with('parent')
            ->orderBy('level')
            ->orderBy('order')
            ->orderBy('name')
            ->paginate(50);
            
        return view('admin.designations.index', compact('designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Designation::where('is_active', true)->orderBy('name')->get();
        return view('admin.designations.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:state,division,district,school',
            'parent_id' => 'nullable|exists:designations,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        Designation::create($validated);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        $parents = Designation::where('id', '!=', $designation->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
            
        return view('admin.designations.edit', compact('designation', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:state,division,district,school',
            'parent_id' => 'nullable|exists:designations,id',
            'order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Prevent circular parent dependency
        if ($validated['parent_id'] == $designation->id) {
            return back()->withErrors(['parent_id' => 'A designation cannot be its own parent.']);
        }

        $designation->update($validated);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
        if ($designation->children()->exists()) {
            return back()->with('error', 'Cannot delete designation with child designations.');
        }

        if ($designation->posts()->exists()) {
            return back()->with('error', 'Cannot delete designation with associated posts.');
        }

        $designation->delete();

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted successfully.');
    }
}
