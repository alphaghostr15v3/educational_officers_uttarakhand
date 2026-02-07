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

        if ($user->role === 'district_admin') {
            $query->whereHas('user.staff.school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
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
        
        if ($user->role === 'district_admin') {
            $usersQuery->whereHas('staff.school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
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

        Leave::create($validated);

        return redirect()->route('admin.leaves.index')->with('success', 'Leave record created successfully.');
    }

    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_remarks' => 'nullable|string',
        ]);

        $leave->update($validated);

        return back()->with('success', 'Leave status updated.');
    }
}
