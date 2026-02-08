<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayGrade;
use Illuminate\Http\Request;

class AdminPayGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payGrades = PayGrade::orderBy('name')->paginate(20);
        return view('admin.pay-grades.index', compact('payGrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pay-grades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'range' => 'required|string|max:255',
            'grade_pay' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        PayGrade::create($request->all());

        return redirect()->route('admin.pay-grades.index')
            ->with('success', 'Pay Grade created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PayGrade $payGrade)
    {
        return view('admin.pay-grades.edit', compact('payGrade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PayGrade $payGrade)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'range' => 'required|string|max:255',
            'grade_pay' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $payGrade->update($request->all());

        return redirect()->route('admin.pay-grades.index')
            ->with('success', 'Pay Grade updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PayGrade $payGrade)
    {
        $payGrade->delete();

        return redirect()->route('admin.pay-grades.index')
            ->with('success', 'Pay Grade deleted successfully.');
    }
}
