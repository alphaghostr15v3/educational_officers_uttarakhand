<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Division;
use App\Models\District;
use App\Models\Officer;
use App\Models\Candidate;

class AdminElectionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Election::with(['division', 'district']);

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id)->orWhere('level', 'state');
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id)
                  ->orWhere('division_id', $user->division_id)
                  ->orWhere('level', 'state');
        }

        $elections = $query->latest()->get();
        return view('admin.elections.index', compact('elections'));
    }

    public function create()
    {
        $divisions = Division::all();
        $districts = District::all();
        $officers = Officer::all();
        return view('admin.elections.create', compact('divisions', 'districts', 'officers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'level' => 'required|in:state,division,district',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        $election = Election::create($validated);

        return redirect()->route('admin.elections.index')->with('success', 'Election created successfully. Now add candidates.');
    }

    public function show(Election $election)
    {
        $election->load(['candidates.officer', 'division', 'district']);
        $officers = Officer::whereDoesntHave('candidates', function($q) use ($election) {
            $q->where('election_id', $election->id);
        })->get();

        return view('admin.elections.show', compact('election', 'officers'));
    }

    public function addCandidate(Request $request, Election $election)
    {
        $validated = $request->validate([
            'officer_id' => 'required|exists:officers,id',
            'symbol' => 'nullable|string',
            'manifesto' => 'nullable|string',
        ]);

        $election->candidates()->create($validated);

        return back()->with('success', 'Candidate added successfully.');
    }

    public function activate(Election $election)
    {
        if ($election->candidates()->count() < 2) {
            return back()->with('error', 'At least 2 candidates are required to activate the election.');
        }

        $election->update(['status' => 'active']);
        return back()->with('success', 'Election is now live!');
    }
}
