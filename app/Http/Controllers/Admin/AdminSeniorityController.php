<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SeniorityList;
use App\Services\ActivityLogService;

class AdminSeniorityController extends Controller
{
    public function index()
    {
        $lists = SeniorityList::with('uploadedBy')->latest()->paginate(10);
        return view('admin.seniority.index', compact('lists'));
    }

    public function create()
    {
        return view('admin.seniority.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer|min:2000|max:' . (date('Y') + 1),
            'cadre' => 'required|string',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('seniority_lists', 'public');
            $validated['file_path'] = $path;
        }

        $validated['uploaded_by'] = auth()->id();
        $validated['is_published'] = true;

        $list = SeniorityList::create($validated);

        ActivityLogService::log('create', "Uploaded seniority list: {$list->title} ({$list->year})", SeniorityList::class, $list->id);

        return redirect()->route('admin.seniority.index')->with('success', 'Seniority list uploaded successfully.');
    }

    public function destroy(SeniorityList $seniority)
    {
        $title = $seniority->title;
        $id = $seniority->id;
        $seniority->delete();

        ActivityLogService::log('delete', "Removed seniority list: {$title}", SeniorityList::class, $id);
        return back()->with('success', 'Seniority list removed.');
    }
}
