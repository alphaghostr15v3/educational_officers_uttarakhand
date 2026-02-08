<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkForm;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminWorkFormController extends Controller
{
    public function index()
    {
        $workForms = WorkForm::with('uploader')->ordered()->get();
        return view('admin.work_forms.index', compact('workForms'));
    }

    public function create()
    {
        return view('admin.work_forms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'work_type' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('work_forms', 'public');
        }

        $validated['uploaded_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['work_type'] = trim($validated['work_type']);

        $workForm = WorkForm::create($validated);

        ActivityLogService::log('create', "Uploaded work form: {$workForm->title}", WorkForm::class, $workForm->id);

        return redirect()->route('admin.work-forms.index')->with('success', 'Work form uploaded successfully.');
    }

    public function edit(WorkForm $workForm)
    {
        return view('admin.work_forms.edit', compact('workForm'));
    }

    public function update(Request $request, WorkForm $workForm)
    {
        $validated = $request->validate([
            'work_type' => 'required|string|max:255',
            'sub_category' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file
            if ($workForm->file_path) {
                Storage::disk('public')->delete($workForm->file_path);
            }
            $validated['file_path'] = $request->file('file')->store('work_forms', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $workForm->sort_order;
        $validated['work_type'] = trim($validated['work_type']);

        $workForm->update($validated);

        ActivityLogService::log('update', "Updated work form: {$workForm->title}", WorkForm::class, $workForm->id);

        return redirect()->route('admin.work-forms.index')->with('success', 'Work form updated successfully.');
    }

    public function destroy(WorkForm $workForm)
    {
        // Delete file
        if ($workForm->file_path) {
            Storage::disk('public')->delete($workForm->file_path);
        }

        $title = $workForm->title;
        $id = $workForm->id;
        $workForm->delete();

        ActivityLogService::log('delete', "Deleted work form: {$title}", WorkForm::class, $id);

        return redirect()->route('admin.work-forms.index')->with('success', 'Work form deleted successfully.');
    }
}
