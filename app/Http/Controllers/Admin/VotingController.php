<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Candidate;

class VotingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $elections = Election::where('status', 'active')
            ->where(function($q) use ($user) {
                $q->where('level', 'state')
                  ->orWhere(function($q) use ($user) {
                      $q->where('level', 'division')->where('division_id', $user->division_id);
                  })
                  ->orWhere(function($q) use ($user) {
                      $q->where('level', 'district')->where('district_id', $user->district_id);
                  });
            })->get();

        return view('admin.elections.vote_list', compact('elections'));
    }

    public function show(Election $election)
    {
        // Check if already voted
        $hasVoted = Vote::where('election_id', $election->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($hasVoted) {
            return redirect()->route('admin.elections.vote.index')->with('info', 'You have already cast your vote for this election.');
        }

        $election->load('candidates.officer');
        return view('admin.elections.cast_vote', compact('election'));
    }

    public function cast(Request $request, Election $election)
    {
        $validated = $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        // Security Check: One vote per user per election
        $alreadyVoted = Vote::where('election_id', $election->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyVoted) {
            return back()->with('error', 'Fraud detected: Multiple votes are not allowed.');
        }

        Vote::create([
            'election_id' => $election->id,
            'user_id' => auth()->id(),
            'candidate_id' => $validated['candidate_id'],
            'voted_at' => now(),
        ]);

        // Increment candidate vote count
        Candidate::where('id', $validated['candidate_id'])->increment('vote_count');

        return redirect()->route('admin.elections.vote.index')->with('success', 'Your vote has been cast successfully!');
    }
}
