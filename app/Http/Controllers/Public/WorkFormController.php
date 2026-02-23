<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\WorkForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkFormController extends Controller
{
    public function index()
    {
        // Public forms are visible to everyone.
        // Login-required forms are only visible when logged in.
        $query = WorkForm::where('is_active', true)->ordered();

        if (!Auth::check()) {
            $query->where('require_login', false);
        }

        $workForms = $query->get()->groupBy('work_type');

        return view('public.work_forms', compact('workForms'));
    }

    public function byType($workType)
    {
        $workType = trim(urldecode($workType));

        // If no public forms exist for this type and user is a guest,
        // check if this type has login-required forms — if so, redirect to login.
        if (!Auth::check()) {
            $hasLoginRequired = WorkForm::where('is_active', true)
                ->where('work_type', $workType)
                ->where('require_login', true)
                ->exists();

            if ($hasLoginRequired) {
                return redirect()->route('login')
                    ->with('error', 'Please log in to view these work forms.');
            }
        }

        $query = WorkForm::where('is_active', true)
            ->where('work_type', $workType)
            ->ordered();

        if (!Auth::check()) {
            $query->where('require_login', false);
        }

        $workForms = $query->get();

        return view('public.work_forms_by_type', compact('workForms', 'workType'));
    }

    public function download($id)
    {
        $workForm = WorkForm::findOrFail($id);

        // If this form requires login and user is not authenticated, redirect to login.
        if ($workForm->require_login && !Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to download this file.');
        }

        // Use increment for atomic update and to avoid race conditions
        $workForm->increment('download_count');

        $filePath = public_path('uploads/work_forms/' . $workForm->file_path);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found on server.');
        }

        return response()->download($filePath, $workForm->title . '.' . pathinfo($workForm->file_path, PATHINFO_EXTENSION));
    }
}
