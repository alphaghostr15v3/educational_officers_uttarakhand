<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use Illuminate\Http\Request;

class EmployeeCircularController extends Controller
{
    public function index()
    {
        $circulars = Circular::where('is_published', true)->latest()->paginate(15);
        return view('employee.circulars.index', compact('circulars'));
    }

    public function show(Circular $circular)
    {
        return view('employee.circulars.show', compact('circular'));
    }
}
