<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolDashboardController extends Controller
{
    public function index()
    {
        $school = auth()->user()->school;
        
        if (!$school) {
             return view('school.no_school_linked');
        }

        $user = auth()->user();

        $data = [
            'school' => $school,
            'staffCount' => $school->staffs()->count(),
            'pendingTransfers' => \App\Models\Transfer::where('user_id', $user->id)->where('status', 'pending')->count(),
            'pendingLeaves' => \App\Models\Leave::where('user_id', $user->id)->where('status', 'pending')->count(),
            'recentDocuments' => \App\Models\SchoolDocument::where('school_id', $school->id)->latest()->take(5)->get(),
            'latestCirculars' => \App\Models\Circular::where('is_published', true)->latest()->take(5)->get(),
        ];

        return view('school.dashboard', $data);
    }
}
