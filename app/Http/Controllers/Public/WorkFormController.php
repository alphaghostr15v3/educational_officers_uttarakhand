<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WorkForm;
use Illuminate\Http\Request;

class WorkFormController extends Controller
{
    public function index()
    {
        // Get all active work forms grouped by work type
        $workForms = WorkForm::where('is_active', true)
                            ->ordered()
                            ->get()
                            ->groupBy('work_type');
        
        return view('public.work_forms', compact('workForms'));
    }

    public function byType($workType)
    {
        $workType = trim(urldecode($workType));
        // Get work forms by specific type
        $workForms = WorkForm::where('is_active', true)
                            ->where('work_type', $workType)
                            ->ordered()
                            ->get();
        
        return view('public.work_forms_by_type', compact('workForms', 'workType'));
    }
}
