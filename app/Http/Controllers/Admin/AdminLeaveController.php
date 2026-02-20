<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class AdminLeaveController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Leave::with('user');

        if ($user->role === 'district_admin' || $user->role === 'block_admin') {
            $query->whereHas('user.staff.school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
                if ($user->role === 'block_admin') {
                    $q->where('block_id', $user->block_id);
                }
            });
        } elseif ($user->role === 'division_admin') {
            $query->whereHas('user.staff.school', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        $leaves = $query->latest()->paginate(15);
        return view('admin.leaves.index', compact('leaves'));
    }

    public function create()
    {
        // Admins can also record leave for employees manually if needed
        $user = auth()->user();
        $usersQuery = User::where('role', 'officer')->with('staff.school');
        
        if ($user->role === 'district_admin' || $user->role === 'block_admin') {
            $usersQuery->whereHas('staff.school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
                if ($user->role === 'block_admin') {
                    $q->where('block_id', $user->block_id);
                }
            });
        } elseif ($user->role === 'division_admin') {
            $usersQuery->whereHas('staff.school', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        $users = $usersQuery->get();

        return view('admin.leaves.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string', // CL, EL, Medical, etc.
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $user = auth()->user();
        $targetUser = User::with('staff.school')->find($validated['user_id']);

        // Authorization check
        if ($user->role === 'block_admin' && (!$targetUser->staff || $targetUser->staff->school->block_id !== $user->block_id)) {
            abort(403, 'You can only record leave for employees in your block.');
        }
        if ($user->role === 'district_admin' && (!$targetUser->staff || $targetUser->staff->school->district_id !== $user->district_id)) {
            abort(403, 'You can only record leave for employees in your district.');
        }
        if ($user->role === 'division_admin' && (!$targetUser->staff || $targetUser->staff->school->division_id !== $user->division_id)) {
            abort(403, 'You can only record leave for employees in your division.');
        }

        Leave::create($validated);

        return redirect()->route('admin.leaves.index')->with('success', 'Leave record created successfully.');
    }

    public function update(Request $request, Leave $leave)
    {
        $user = auth()->user();
        $leave->load('user.staff.school');

        // Authorization check
        if ($user->role === 'block_admin' && (!$leave->user->staff || $leave->user->staff->school->block_id !== $user->block_id)) {
            abort(403);
        }
        if ($user->role === 'district_admin' && (!$leave->user->staff || $leave->user->staff->school->district_id !== $user->district_id)) {
            abort(403);
        }
        if ($user->role === 'division_admin' && (!$leave->user->staff || $leave->user->staff->school->division_id !== $user->division_id)) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string',
        ]);

        $leave->update($validated);

        return back()->with('success', 'Leave status updated.');
    }
}
