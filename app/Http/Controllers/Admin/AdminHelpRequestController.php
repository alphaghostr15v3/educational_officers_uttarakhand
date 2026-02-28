<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpRequest;
use App\Models\Division;
use App\Models\District;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;

class AdminHelpRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = HelpRequest::with('employee');

        // Filter based on admin role and region
        if ($user->role === 'state_admin' || $user->role === 'admin_panel') {
            // State Admin and Admin Panel see ALL requests (no filter)
        } elseif ($user->role === 'division_admin') {
            $query->where('target_level', 'division')
                  ->where('target_division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $query->where('target_level', 'district')
                  ->where('target_district_id', $user->district_id);
        } elseif ($user->role === 'block_admin') {
            $query->where('target_level', 'block')
                  ->where('target_block_id', $user->block_id);
        } else {
            // If they don't have a recognized admin role for help requests
            abort(403);
        }

        $requests = $query->latest()->paginate(15);
        return view('admin.help-requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,resolved,closed',
            'admin_reply' => 'nullable|string',
        ]);

        $helpRequest = HelpRequest::findOrFail($id);
        
        $helpRequest->update([
            'status' => $request->status,
            'admin_reply' => $request->admin_reply,
        ]);

        return back()->with('success', 'Help request status updated.');
    }
}
