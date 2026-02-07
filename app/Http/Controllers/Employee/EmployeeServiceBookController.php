<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\Leave;
use App\Models\Staff;
use Illuminate\Http\Request;

class EmployeeServiceBookController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['division', 'district', 'staff.school']);
        
        $transfers = Transfer::where('user_id', $user->id)
            ->with(['fromSchool', 'toSchool'])
            ->latest()
            ->get();
            
        $leaves = Leave::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('employee.service_book.index', compact('user', 'transfers', 'leaves'));
    }

    public function requestCorrection()
    {
        return view('employee.service_book.correction');
    }

    public function submitCorrection(Request $request)
    {
        $request->validate([
            'field_name' => 'required|string',
            'current_value' => 'required|string',
            'suggested_value' => 'required|string',
            'reason' => 'required|string|min:10',
        ]);

        // For now, we'll just log this or flash success. 
        // In a real app, you'd store this in a 'correction_requests' table.
        return back()->with('success', 'Your correction request has been submitted to the admin.');
    }
}
