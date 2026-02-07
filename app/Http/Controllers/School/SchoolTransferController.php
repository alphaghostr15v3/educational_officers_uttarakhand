<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolTransferController extends Controller
{
    public function create()
    {
        $currentSchoolId = auth()->user()->school_id;
        $schools = School::where('id', '!=', $currentSchoolId)->where('is_active', true)->orderBy('name')->get();
        return view('school.transfers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'to_school_id' => 'required|exists:schools,id',
            'reason' => 'required|string|min:10',
        ]);

        Transfer::create([
            'user_id' => auth()->id(),
            'from_school_id' => auth()->user()->school_id,
            'to_school_id' => $request->to_school_id,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('school.dashboard')->with('success', 'Transfer application submitted successfully.');
    }
}
