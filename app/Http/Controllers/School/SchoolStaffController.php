<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
            'joining_date' => 'required|date',
            'employee_code' => 'nullable|string|unique:users,employee_code',
        ]);

        // Create User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'), // Default
            'mobile' => $validated['mobile'],
            'role' => 'employee',
            'school_id' => $school->id, // If they are associated with this school
            'employee_code' => $validated['employee_code'],
            'is_active' => true,
        ]);

        // Create Staff Record
        Staff::create([
            'user_id' => $user->id,
            'school_id' => $school->id,
            'designation' => $validated['designation'],
            'joining_date' => $validated['joining_date'],
            'current_status' => 'active',
        ]);

        return redirect()->route('school.staff.index')->with('success', 'Staff member added successfully.');
    }
}
