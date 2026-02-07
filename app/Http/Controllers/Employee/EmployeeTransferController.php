<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\School;
use Illuminate\Http\Request;

class EmployeeTransferController extends Controller
{
    public function index()
    {
        $transfers = Transfer::where('user_id', auth()->id())->latest()->get();
        return view('employee.transfers.index', compact('transfers'));
    }

    public function create()
    {
        $schools = School::orderBy('name')->get();
        return view('employee.transfers.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'to_school_id' => 'required|exists:schools,id',
            'reason' => 'required|string|min:10',
        ]);

        $user = auth()->user();
        
        Transfer::create([
            'user_id' => $user->id,
            'from_school_id' => $user->school_id, // If they are linked to a school
            'to_school_id' => $validated['to_school_id'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('employee.transfers.index')->with('success', 'Transfer application submitted successfully.');
    }
}
