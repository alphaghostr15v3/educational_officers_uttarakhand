<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\SanctionedPost;
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

        // Calculate sanctioned posts and vacancies from SanctionedPost model
        $schools->getCollection()->transform(function ($school) {
            // Sum all active sanctioned posts for this school
            $school->sanctioned_posts = SanctionedPost::where('school_id', $school->id)
                ->where('is_active', true)
                ->sum('sanctioned_count');
            
            $school->vacancy = $school->sanctioned_posts - $school->staffs_count;
            return $school;
        });

        return view('admin.vacancy.index', compact('schools'));
    }
}
