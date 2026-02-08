<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SchoolStaffController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school;
        $staffs = Staff::where('school_id', $school->id)->with('user')->latest()->paginate(20);
        return view('school.staff.index', compact('staffs'));
    }

    public function create()
    {
        // View to register new staff
        return view('school.staff.create');
    }

    public function store(Request $request)
    {
        $school = auth()->user()->school;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:15',
            'designation' => 'required|string',
            'subject' => 'nullable|string',
            'joining_date' => 'required|date',
            'retirement_date' => 'nullable|date',
            'employee_code' => 'nullable|string|unique:users,employee_code',
        ]);

        try {
            DB::beginTransaction();

            // Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('password123'), // Default
                'mobile' => $validated['mobile'],
                'role' => 'officer',
                'school_id' => $school->id,
                'employee_code' => $validated['employee_code'],
                'is_active' => true,
            ]);

            // Create Staff Record
            Staff::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'designation' => $validated['designation'],
                'subject' => $validated['subject'],
                'joining_date' => $validated['joining_date'],
                'retirement_date' => $validated['retirement_date'],
                'current_status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('school.staff.index')->with('success', 'Staff member added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add staff: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Staff $staff)
    {
        // Ensure staff belongs to this school
        if ($staff->school_id !== auth()->user()->school_id) {
            abort(403);
        }
        return view('school.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        if ($staff->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staff->user_id,
            'mobile' => 'required|string|max:15',
            'designation' => 'required|string',
            'subject' => 'nullable|string',
            'joining_date' => 'required|date',
            'retirement_date' => 'nullable|date',
            'employee_code' => 'nullable|string|unique:users,employee_code,' . $staff->user_id,
            'current_status' => 'required|in:active,inactive,on_leave,transferred',
        ]);

        try {
            DB::beginTransaction();

            $staff->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'employee_code' => $validated['employee_code'],
            ]);

            $staff->update([
                'designation' => $validated['designation'],
                'subject' => $validated['subject'],
                'joining_date' => $validated['joining_date'],
                'retirement_date' => $validated['retirement_date'],
                'current_status' => $validated['current_status'],
            ]);

            DB::commit();

            return redirect()->route('school.staff.index')->with('success', 'Staff member updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update staff: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Staff $staff)
    {
        if ($staff->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $staff->delete(); // Usually we might want to keep the user record or soft delete
        return redirect()->route('school.staff.index')->with('success', 'Staff record deleted.');
    }
}
