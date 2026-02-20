<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\School;
use App\Models\User;
use App\Models\Designation;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class DistrictStaffController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['district_admin', 'division_admin', 'state_admin', 'block_admin'])) {
            abort(403);
        }

        $query = Staff::query();

        if ($user->role === 'district_admin' || $user->role === 'block_admin') {
            // Filter staff belonging to schools in this district
            $query->whereHas('school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
                if ($user->role === 'block_admin') {
                    $q->where('block_id', $user->block_id);
                }
            });
        } elseif ($user->role === 'division_admin') {
            // Filter staff belonging to schools in this division
            $query->whereHas('school', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        $staffs = $query->with(['school', 'user'])->latest()->paginate(20);

        return view('admin.staff.index', compact('staffs'));
    }

    public function create()
    {
         $user = auth()->user();
         $schools = [];
         
         if ($user->role === 'block_admin') {
             $schools = School::where('block_id', $user->block_id)->get();
         } elseif ($user->role === 'district_admin') {
             $schools = School::where('district_id', $user->district_id)->get();
         } elseif ($user->role === 'division_admin') {
             $schools = School::where('division_id', $user->division_id)->get();
         } else {
             $schools = School::all(); 
         }

         $designations = Designation::where('is_active', true)->orderBy('level')->orderBy('order')->get();
         return view('admin.staff.create', compact('schools', 'designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'mobile'       => 'required|string|max:15',
            'designation'  => 'required|string',
            'school_id'    => 'required|exists:schools,id',
            'joining_date' => 'required|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $school = School::find($validated['school_id']);

        // Authorization check for the selected school
        if ($user->role === 'block_admin' && $school->block_id !== $user->block_id) {
            abort(403, 'You can only add staff to schools within your block.');
        }
        if ($user->role === 'district_admin' && $school->district_id !== $user->district_id) {
            abort(403, 'You can only add staff to schools within your district.');
        }
        if ($user->role === 'division_admin' && $school->division_id !== $user->division_id) {
            abort(403, 'You can only add staff to schools within your division.');
        }

        // Create User first
        $imagePath = null;
        if ($request->hasFile('profile_picture')) {
            $image    = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_pictures'), $filename);
            $imagePath = 'uploads/profile_pictures/' . $filename;
        }

        $user = User::create([
            'name'            => $validated['name'],
            'email'           => $validated['email'],
            'password'        => \Illuminate\Support\Facades\Hash::make('password123'),
            'mobile'          => $validated['mobile'],
            'role'            => 'officer',
            'profile_picture' => $imagePath,
            'is_active'       => true,
        ]);

        // Create Staff Record
        Staff::create([
            'user_id' => $user->id,
            'school_id' => $validated['school_id'],
            'designation' => $validated['designation'],
            'joining_date' => $validated['joining_date'],
            'current_status' => 'active',
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully. Default password is "password123".');
    }
    public function export()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['district_admin', 'division_admin', 'state_admin'])) {
            abort(403);
        }

        $query = Staff::with(['school', 'user']);

        if ($user->role === 'district_admin' || $user->role === 'block_admin') {
            $query->whereHas('school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
                if ($user->role === 'block_admin') {
                    $q->where('block_id', $user->block_id);
                }
            });
        } elseif ($user->role === 'division_admin') {
            $query->whereHas('school', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        }

        $staffs = $query->get();
        $filename = "staff_report_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($staffs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Name', 'Email', 'Designation', 'School', 'District', 'Joining Date', 'Status']);

            foreach ($staffs as $staff) {
                fputcsv($file, [
                    $staff->id,
                    $staff->user->name ?? 'N/A',
                    $staff->user->email ?? 'N/A',
                    $staff->designation,
                    $staff->school->name ?? 'N/A',
                    $staff->school->district->name ?? 'N/A',
                    $staff->joining_date,
                    $staff->current_status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function show(Staff $staff)
    {
        $user = auth()->user();
        
        // Authorization check
        if (($user->role === 'district_admin' || $user->role === 'block_admin') && $staff->school->district_id !== $user->district_id) {
            abort(403);
        }
        if ($user->role === 'block_admin' && $staff->school->block_id !== $user->block_id) {
            abort(403);
        }
        if ($user->role === 'division_admin' && $staff->school->division_id !== $user->division_id) {
            abort(403);
        }

        $staff->load(['school.district', 'school.division', 'user']);
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $user = auth()->user();
        if (($user->role === 'district_admin' || $user->role === 'block_admin') && $staff->school->district_id !== $user->district_id) {
            abort(403);
        }
        if ($user->role === 'block_admin' && $staff->school->block_id !== $user->block_id) {
            abort(403);
        }

        $schools = [];
        if ($user->role === 'block_admin') {
            $schools = School::where('block_id', $user->block_id)->get();
        } elseif ($user->role === 'district_admin') {
            $schools = School::where('district_id', $user->district_id)->get();
        } elseif ($user->role === 'division_admin') {
            $schools = School::where('division_id', $user->division_id)->get();
        } else {
            $schools = School::all();
        }

        $designations = Designation::where('is_active', true)->orderBy('level')->orderBy('order')->get();
        return view('admin.staff.create', compact('staff', 'schools', 'designations')); // Reusing create view as its fields are mostly the same
    }

    public function update(Request $request, Staff $staff)
    {
        $user = auth()->user();
        
        // Authorization check for the staff record
        if ($user->role === 'block_admin' && $staff->school->block_id !== $user->block_id) {
            abort(403);
        }
        if ($user->role === 'district_admin' && $staff->school->district_id !== $user->district_id) {
            abort(403);
        }
        if ($user->role === 'division_admin' && $staff->school->division_id !== $user->division_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $staff->user_id,
            'mobile'          => 'required|string|max:15',
            'designation'     => 'required|string',
            'school_id'       => 'required|exists:schools,id',
            'joining_date'    => 'required|date',
            'current_status'  => 'required|in:active,inactive,on_leave,retired,transferred,suspended',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $userUpdates = [
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'mobile' => $validated['mobile'],
        ];

        if ($request->hasFile('profile_picture')) {
            // Delete old image if exists
            if ($staff->user->profile_picture && file_exists(public_path($staff->user->profile_picture))) {
                unlink(public_path($staff->user->profile_picture));
            }
            $image    = $request->file('profile_picture');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_pictures'), $filename);
            $userUpdates['profile_picture'] = 'uploads/profile_pictures/' . $filename;
        }

        $staff->user->update($userUpdates);

        $staff->update([
            'school_id' => $validated['school_id'],
            'designation' => $validated['designation'],
            'joining_date' => $validated['joining_date'],
            'current_status' => $validated['current_status'],
        ]);

        ActivityLogService::log('update', "Updated staff profile: {$staff->user->name}", Staff::class, $staff->id);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
        $user = auth()->user();
        if ($user->role !== 'state_admin' && $user->role !== 'division_admin' && 
           (($user->role === 'district_admin' || $user->role === 'block_admin') && $staff->school->district_id !== $user->district_id)) {
            abort(403);
        }
        if ($user->role === 'block_admin' && $staff->school->block_id !== $user->block_id) {
            abort(403);
        }

        $name = $staff->user->name;
        $id = $staff->id;
        
        // Soft delete or handle dependencies if necessary
        $staff->user->delete();
        $staff->delete();

        ActivityLogService::log('delete', "Removed staff member: {$name}", Staff::class, $id);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member removed successfully.');
    }
}
