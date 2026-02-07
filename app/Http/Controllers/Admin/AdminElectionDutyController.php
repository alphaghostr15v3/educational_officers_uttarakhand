<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ElectionDuty;
use App\Models\User;
use App\Services\ActivityLogService;

class AdminElectionDutyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = ElectionDuty::with(['user.district', 'user.staff.school']);

        if ($user->role === 'district_admin') {
            $query->whereHas('user.staff.school', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        } elseif ($user->role === 'division_admin') {
            $query->whereHas('user.staff.school', function ($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        $duties = $query->latest()->paginate(15);
        return view('admin.elections.duties.index', compact('duties'));
    }

    public function create()
    {
        $user = auth()->user();
        $query = User::where('role', 'officer')->with('staff.school');

        if ($user->role === 'district_admin') {
            $query->whereHas('staff.school', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        }

        $employees = $query->get();
        return view('admin.elections.duties.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'election_name' => 'required|string',
            'duty_type' => 'required|string',
            'location' => 'nullable|string',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'order_number' => 'nullable|string',
            'status' => 'required|in:assigned,completed,exempted',
            'remarks' => 'nullable|string',
        ]);

        $duty = ElectionDuty::create($validated);

        ActivityLogService::log('create', "Election duty assigned to User ID: {$validated['user_id']}", ElectionDuty::class, $duty->id);

        return redirect()->route('admin.election-duties.index')->with('success', 'Election duty assigned successfully.');
    }

    public function edit(ElectionDuty $election_duty)
    {
        $user = auth()->user();
        
        // Authorization check
        if ($user->role === 'district_admin' && $election_duty->user->staff->school->district_id !== $user->district_id) {
            abort(403);
        }

        $query = User::where('role', 'officer')->with('staff.school');
        if ($user->role === 'district_admin') {
            $query->whereHas('staff.school', function ($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        }
        $employees = $query->get();

        return view('admin.elections.duties.edit', compact('election_duty', 'employees'));
    }

    public function update(Request $request, ElectionDuty $election_duty)
    {
        $user = auth()->user();
        if ($user->role === 'district_admin' && $election_duty->user->district_id !== $user->district_id) {
            abort(403);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'election_name' => 'required|string',
            'duty_type' => 'required|string',
            'location' => 'nullable|string',
            'from_date' => 'required|date',
            'to_date' => 'nullable|date|after_or_equal:from_date',
            'order_number' => 'nullable|string',
            'status' => 'required|in:assigned,completed,exempted',
            'remarks' => 'nullable|string',
        ]);

        $election_duty->update($validated);

        ActivityLogService::log('update', "Election duty updated for User ID: {$election_duty->user_id}", ElectionDuty::class, $election_duty->id);

        return redirect()->route('admin.election-duties.index')->with('success', 'Election duty record updated successfully.');
    }

    public function destroy(ElectionDuty $election_duty)
    {
        $user = auth()->user();
        if ($user->role === 'district_admin' && $election_duty->user->district_id !== $user->district_id) {
            abort(403);
        }

        $election_duty->delete();
        return redirect()->route('admin.election-duties.index')->with('success', 'Election duty record deleted.');
    }
}
