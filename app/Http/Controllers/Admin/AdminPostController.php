<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SanctionedPost;
use App\Models\Designation;
use App\Models\School;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SanctionedPost::with(['designation', 'school', 'district', 'division']);

        // Filtering
        if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        if ($request->has('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

        $posts = $query->paginate(20);
        
        $designations = Designation::where('is_active', true)->get();
        
        return view('admin.posts.index', compact('posts', 'designations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $designations = Designation::where('is_active', true)->orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $divisions = Division::orderBy('name')->get();
        // Schools loaded via AJAX typically, but for now passing empty or all depends on scale.
        // Let's pass empty and assume AJAX or search in real app, but for simplicity here just null.
        
        return view('admin.posts.create', compact('designations', 'districts', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'designation_id' => 'required|exists:designations,id',
            'level' => 'required|in:state,division,district,school',
            'school_id' => 'nullable|required_if:level,school|exists:schools,id',
            'district_id' => 'nullable|required_if:level,district|exists:districts,id',
            'division_id' => 'nullable|required_if:level,division|exists:divisions,id',
            'sanctioned_count' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        // Check unique constraint manually if needed (e.g. one record per designation per unit)
        $existsQuery = SanctionedPost::where('designation_id', $validated['designation_id'])
            ->where('level', $validated['level']);
            
        if ($validated['level'] == 'school') $existsQuery->where('school_id', $validated['school_id']);
        if ($validated['level'] == 'district') $existsQuery->where('district_id', $validated['district_id']);
        if ($validated['level'] == 'division') $existsQuery->where('division_id', $validated['division_id']);
        
        $exists = $existsQuery->first();

        if ($exists) {
            // Update existing instead of creating new if it exists
            $exists->update([
                'sanctioned_count' => $validated['sanctioned_count'],
                'is_active' => $validated['is_active'] ?? true,
            ]);
            $msg = 'Sanctioned post updated successfully.';
        } else {
            SanctionedPost::create($validated);
            $msg = 'Sanctioned post created successfully.';
        }

        return redirect()->route('admin.posts.index')
            ->with('success', $msg);
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
    public function edit(SanctionedPost $post)
    {
        $designations = Designation::where('is_active', true)->get();
        $districts = District::all();
        $divisions = Division::all();
        $schools = School::limit(10)->get(); // Example limit
        
        return view('admin.posts.edit', compact('post', 'designations', 'districts', 'divisions', 'schools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SanctionedPost $post)
    {
         $validated = $request->validate([
            'sanctioned_count' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SanctionedPost $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
