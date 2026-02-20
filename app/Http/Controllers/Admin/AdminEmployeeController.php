<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use App\Models\School;
use App\Models\Designation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminEmployeeController extends Controller
{
    /**
     * Display a listing of employees (users with role 'officer').
     */
    public function index()
    {
        $user = auth()->user();
        
        $query = User::with(['staff.school', 'block', 'district'])
            ->where('role', 'officer')
            ->latest();

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        } elseif ($user->role === 'block_admin') {
            $query->where('block_id', $user->block_id);
        }

        $employees = $query->paginate(20);

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $user = auth()->user();
        $designations = Designation::where('is_active', true)->orderBy('level')->get();
        
        $schoolQuery = School::where('is_active', true);

        if ($user->role === 'division_admin') {
            $schoolQuery->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $schoolQuery->where('district_id', $user->district_id);
        } elseif ($user->role === 'block_admin') {
            $schoolQuery->where('block_id', $user->block_id);
        }

        $schools = $schoolQuery->orderBy('name')->get();

        return view('admin.employees.create', compact('designations', 'schools'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $admin = auth()->user();

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'mobile'          => 'required|string|max:15',
            'dob'             => 'nullable|date',
            'designation'     => 'required|string',
            'joining_date'    => 'required|date',
            'employee_code'   => 'required|string|unique:users,employee_code',
            'school_id'       => 'required|exists:schools,id',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Security Check: Ensure school belongs to admin's jurisdiction
        $school = School::findOrFail($validated['school_id']);
        if ($admin->role === 'division_admin' && $school->division_id !== $admin->division_id) {
            abort(403);
        } elseif ($admin->role === 'district_admin' && $school->district_id !== $admin->district_id) {
            abort(403);
        } elseif ($admin->role === 'block_admin' && $school->block_id !== $admin->block_id) {
            abort(403);
        }

        try {
            DB::beginTransaction();

            $defaultPassword = ($admin->role === 'block_admin') ? 'block@123' : 'district@123';

            $imagePath = null;
            if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/profile_pictures'), $filename);
                $imagePath = 'uploads/profile_pictures/' . $filename;
            }

            $user = User::create([
                'name'            => $validated['name'],
                'email'           => $validated['email'],
                'password'        => Hash::make($defaultPassword),
                'role'            => 'officer',
                'mobile'          => $validated['mobile'],
                'dob'             => $validated['dob'] ?? null,
                'employee_code'   => $validated['employee_code'],
                'division_id'     => $school->division_id,
                'district_id'     => $school->district_id,
                'block_id'        => $school->block_id,
                'school_id'       => $school->id,
                'profile_picture' => $imagePath,
                'is_active'       => true,
            ]);

            Staff::create([
                'user_id' => $user->id,
                'school_id' => $school->id,
                'designation' => $validated['designation'],
                'joining_date' => $validated['joining_date'],
                'current_status' => 'active',
            ]);

            DB::commit();

            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create employee: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified employee.
     */
    public function show(User $employee)
    {
        $admin = auth()->user();

        // Security Check
        if ($admin->role === 'division_admin' && $employee->division_id !== $admin->division_id) {
            abort(403);
        } elseif ($admin->role === 'district_admin' && $employee->district_id !== $admin->district_id) {
            abort(403);
        } elseif ($admin->role === 'block_admin' && $employee->block_id !== $admin->block_id) {
            abort(403);
        }

        if ($employee->role !== 'officer') {
            abort(404);
        }

        $employee->load(['staff.school', 'block', 'district', 'division']);
        
        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing an employee.
     */
    public function edit(User $employee)
    {
        $admin = auth()->user();

        // Jurisdiction check
        if ($admin->role === 'division_admin' && $employee->division_id !== $admin->division_id) abort(403);
        elseif ($admin->role === 'district_admin' && $employee->district_id !== $admin->district_id) abort(403);
        elseif ($admin->role === 'block_admin' && $employee->block_id !== $admin->block_id) abort(403);

        if ($employee->role !== 'officer') abort(404);

        $designations = Designation::where('is_active', true)->orderBy('level')->get();
        $schoolQuery  = School::where('is_active', true);

        if ($admin->role === 'division_admin') $schoolQuery->where('division_id', $admin->division_id);
        elseif ($admin->role === 'district_admin') $schoolQuery->where('district_id', $admin->district_id);
        elseif ($admin->role === 'block_admin') $schoolQuery->where('block_id', $admin->block_id);

        $schools = $schoolQuery->orderBy('name')->get();

        return view('admin.employees.edit', compact('employee', 'designations', 'schools'));
    }

    /**
     * Update an employee's personal information.
     */
    public function update(Request $request, User $employee)
    {
        $admin = auth()->user();

        // Jurisdiction check
        if ($admin->role === 'division_admin' && $employee->division_id !== $admin->division_id) abort(403);
        elseif ($admin->role === 'district_admin' && $employee->district_id !== $admin->district_id) abort(403);
        elseif ($admin->role === 'block_admin' && $employee->block_id !== $admin->block_id) abort(403);

        if ($employee->role !== 'officer') abort(404);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $employee->id,
            'mobile'          => 'required|string|max:15',
            'dob'             => 'nullable|date',
            'employee_code'   => 'required|string|unique:users,employee_code,' . $employee->id,
            'school_id'       => 'required|exists:schools,id',
            'designation'     => 'required|string',
            'joining_date'    => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Verify school belongs to admin's jurisdiction
        $school = School::findOrFail($validated['school_id']);
        if ($admin->role === 'district_admin' && $school->district_id !== $admin->district_id) abort(403);
        elseif ($admin->role === 'block_admin' && $school->block_id !== $admin->block_id) abort(403);

        $userUpdates = [
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'mobile'        => $validated['mobile'],
            'dob'           => $validated['dob'] ?? null,
            'employee_code' => $validated['employee_code'],
            'school_id'     => $school->id,
            'division_id'   => $school->division_id,
            'district_id'   => $school->district_id,
            'block_id'      => $school->block_id,
        ];

        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture && file_exists(public_path($employee->profile_picture))) {
                unlink(public_path($employee->profile_picture));
            }
            $image    = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_pictures'), $filename);
            $userUpdates['profile_picture'] = 'uploads/profile_pictures/' . $filename;
        }

        $employee->update($userUpdates);

        // Update staff record too
        if ($employee->staff) {
            $employee->staff->update([
                'school_id'    => $school->id,
                'designation'  => $validated['designation'],
                'joining_date' => $validated['joining_date'],
            ]);
        }

        return redirect()->route('admin.employees.show', $employee)->with('success', 'Employee profile updated successfully.');
    }
}
