<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Circular;
use App\Models\Division;
use App\Models\District;
use App\Services\ActivityLogService;

class AdminCircularController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Circular::with(['uploadedBy', 'division', 'district']);

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id)->orWhere('level', 'state');
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id)->orWhere('level', 'state');
        }

        $circulars = $query->latest()->paginate(15);
        return view('admin.circulars.index', compact('circulars'));
    }

    public function create()
    {
        $divisions = Division::all();
        $districts = District::all();
        return view('admin.circulars.create', compact('divisions', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'circular_number' => 'required|string|unique:circulars',
            'circular_date' => 'required|date',
            'level' => 'required|in:state,division,district',
            'division_id' => 'nullable|required_if:level,division,district|exists:divisions,id',
            'district_id' => 'nullable|required_if:level,district|exists:districts,id',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('circulars', 'public');
            $validated['file_path'] = $path;
        }

        $validated['uploaded_by'] = auth()->id();
        $circular = Circular::create($validated);

        ActivityLogService::log('create', "Uploaded new circular: {$circular->circular_number} - {$circular->title}", Circular::class, $circular->id);

        return redirect()->route('admin.circulars.index')->with('success', 'Circular uploaded successfully.');
    }
}
