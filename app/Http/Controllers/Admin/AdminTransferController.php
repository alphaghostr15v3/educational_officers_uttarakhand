<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;

class AdminTransferController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Transfer::with(['user', 'fromSchool', 'toSchool']);

        if ($user->role === 'district_admin') {
            // District Admin sees pending requests from their district
            $query->whereHas('user', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
            })->where('status', Transfer::STATUS_PENDINGDistrict);
        } elseif ($user->role === 'division_admin') {
            // Division Admin sees requests forwarded by districts in their division
            $query->whereHas('user', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            })->where('status', Transfer::STATUS_DISTRICT_FORWARDED);
        } elseif ($user->role === 'state_admin') {
            // State Admin sees requests recommended by divisions
            $query->where('status', Transfer::STATUS_DIVISION_RECOMMENDED);
        }
        // State Admin or Super Admins might want to see all sometimes, but for workflow we focus on relevant

        $transfers = $query->latest()->paginate(15);
        return view('admin.transfers.index', compact('transfers'));
    }

    public function create()
    {
        $user = auth()->user();
        $usersQuery = User::where('role', 'employee');
        $officesQuery = School::query();

        if ($user->role === 'district_admin') {
            $usersQuery->where('district_id', $user->district_id);
            $officesQuery->where('district_id', $user->district_id);
        } elseif ($user->role === 'division_admin') {
            $usersQuery->where('division_id', $user->division_id);
            $officesQuery->where('division_id', $user->division_id);
        }

        $users = $usersQuery->get(); 
        $offices = $officesQuery->get(); 
        
        return view('admin.transfers.create', compact('users', 'offices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'from_office_id' => 'required|exists:schools,id',
            'to_office_id' => 'required|exists:schools,id|different:from_office_id',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $transfer = Transfer::create($validated);
        
        return redirect()->route('admin.transfers.index')->with('success', 'Transfer request created successfully.');
    }

    public function updateStatus(Request $request, Transfer $transfer)
    {
        $validated = $request->validate([
            'action' => 'required|in:forward,recommend,approve,reject',
            'admin_remarks' => 'nullable|string',
        ]);

        $user = auth()->user();
        $status = $transfer->status;

        if ($validated['action'] === 'reject') {
            $status = Transfer::STATUS_REJECTED;
        } else {
            if ($user->role === 'district_admin' && $status === Transfer::STATUS_PENDINGDistrict) {
                $status = Transfer::STATUS_DISTRICT_FORWARDED;
            } elseif ($user->role === 'division_admin' && $status === Transfer::STATUS_DISTRICT_FORWARDED) {
                $status = Transfer::STATUS_DIVISION_RECOMMENDED;
            } elseif ($user->role === 'state_admin' && $status === Transfer::STATUS_DIVISION_RECOMMENDED) {
                $status = Transfer::STATUS_APPROVED;
            } else {
                return back()->with('error', 'Unauthorized action for this transfer status.');
            }
        }

        $transfer->update([
            'status' => $status,
            'admin_remarks' => $validated['admin_remarks'],
        ]);

        if ($status === Transfer::STATUS_APPROVED) {
            // Final approval logic: update staff's school
            $staff = \App\Models\Staff::where('user_id', $transfer->user_id)->first();
            if ($staff) {
                $staff->update(['school_id' => $transfer->to_school_id]);
            }
        }

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer request updated successfully.');
    }
}
