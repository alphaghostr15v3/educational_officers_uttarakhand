<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class AdminVacancyController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $query = School::query();

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id);
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        }
        
        // Eager load staff count
        $schools = $query->withCount('staffs')->paginate(20);

        // Simulate sanctioned posts for now (e.g. 10 per school)
        // In real app, this would be a column in schools table or a related table
        $schools->getCollection()->transform(function ($school) {
            $school->sanctioned_posts = 10; // Placeholder
            $school->vacancy = $school->sanctioned_posts - $school->staffs_count;
            return $school;
        });

        return view('admin.vacancy.index', compact('schools'));
    }
}
