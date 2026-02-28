<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Division;
use App\Models\District;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class EmployeeHelpController extends Controller
{
    public function index()
    {
        $requests = HelpRequest::where('employee_id', Auth::id())
            ->latest()
            ->paginate(10);
            
        return view('employee.help.index', compact('requests'));
    }

    public function create()
    {
        $divisions = Division::orderBy('name')->get();
        $districts = District::orderBy('name')->get();
        $blocks = Block::orderBy('name')->get();
        
        return view('employee.help.create', compact('divisions', 'districts', 'blocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'target_level' => 'required|in:state,division,district,block',
            'target_id' => 'required_if:target_level,division,district,block',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $user = Auth::user();
        
        $data = [
            'employee_id' => $user->id,
            'target_level' => $request->target_level,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'pending',
        ];

        // Specific routing based on selection
        if ($request->target_level === 'division') {
            $data['target_division_id'] = $request->target_id;
        } elseif ($request->target_level === 'district') {
            $data['target_district_id'] = $request->target_id;
        } elseif ($request->target_level === 'block') {
            $data['target_block_id'] = $request->target_id;
        }
        // 'state' level doesn't need a specific ID (it goes to all state admins)

        HelpRequest::create($data);

        return redirect()->route('employee.help.index')->with('success', 'Help request submitted successfully.');
    }
}
