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
        
        $query = Transfer::with(['user', 'fromOffice', 'toOffice']);

        if ($user->role === 'district_admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        } elseif ($user->role === 'division_admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        } 
        // State Admin sees all

        $transfers = $query->latest()->paginate(15);

        return view('admin.transfers.index', compact('transfers'));
    }

    public function create()
    {
        $user = auth()->user();
        $usersQuery = User::where('role', 'officer')->with('staff');
        $officesQuery = School::query();

        if ($user->role === 'district_admin') {
            $usersQuery->whereHas('staff.school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
            $officesQuery->where('district_id', $user->district_id);
        } elseif ($user->role === 'division_admin') {
            $usersQuery->whereHas('staff.school', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
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
            'from_school_id' => 'required|exists:schools,id',
            'to_school_id' => 'required|exists:schools,id|different:from_school_id',
            'reason' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            $transfer = Transfer::create($validated);
            
            if ($transfer->status === 'approved') {
                $staff = \App\Models\Staff::where('user_id', $transfer->user_id)->first();
                if ($staff) {
                    $staff->update(['school_id' => $transfer->to_school_id]);
                }
            }

            return redirect()->route('admin.transfers.index')->with('success', 'Transfer request created successfully.');
        } catch (\Exception $e) {
            \Log::error('Transfer Creation Failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create transfer: ' . $e->getMessage());
        }
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
            'admin_remarks' => $validated['admin_remarks'] ?? null,
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
