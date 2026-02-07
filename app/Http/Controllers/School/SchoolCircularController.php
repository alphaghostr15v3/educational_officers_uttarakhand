<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Circular;
use Illuminate\Http\Request;

class SchoolCircularController extends Controller
{
    public function index()
    {
        // Simple logic: Show all published circulars for now.
        // In verify phase, we can refine to show only relevant ones (based on level).
        $circulars = Circular::where('is_published', true)->latest()->paginate(10);
        return view('school.circulars.index', compact('circulars'));
    }

    public function show(Circular $circular)
    {
        return view('school.circulars.show', compact('circular'));
    }
}
