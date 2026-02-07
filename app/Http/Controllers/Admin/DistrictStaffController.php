<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class DistrictStaffController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['district_admin', 'division_admin', 'state_admin'])) {
            abort(403);
        }

        $query = Staff::query();

        if ($user->role === 'district_admin') {
            // Filter staff belonging to schools in this district
            $query->whereHas('school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
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
         
         if ($user->role === 'district_admin') {
             $schools = School::where('district_id', $user->district_id)->get();
         } elseif ($user->role === 'division_admin') {
             $schools = School::where('division_id', $user->division_id)->get();
         } else {
             $schools = School::all(); 
         }

         return view('admin.staff.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // User name
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:15',
            'designation' => 'required|string',
            'school_id' => 'required|exists:schools,id',
            'joining_date' => 'required|date',
        ]);

        // Create User first
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make('password123'), // Default password
            'mobile' => $validated['mobile'],
            'role' => 'employee',
            'is_active' => true,
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

        if ($user->role === 'district_admin') {
            $query->whereHas('school', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
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
}
