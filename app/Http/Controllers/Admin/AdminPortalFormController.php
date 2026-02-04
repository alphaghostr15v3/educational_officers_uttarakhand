<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPortalFormController extends Controller
{
    public function index()
    {
        $forms = PortalForm::orderBy('sort_order')->get();
        return view('admin.portal_forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.portal_forms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'hindi_title' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'external_url' => 'nullable|url',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('portal/icons', 'public');
        }

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')->store('portal/forms', 'public');
        }

        PortalForm::create($validated);

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form added successfully.');
    }

    public function edit(PortalForm $portal_form)
    {
        return view('admin.portal_forms.edit', compact('portal_form'));
    }

    public function update(Request $request, PortalForm $portal_form)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'hindi_title' => 'nullable|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,zip|max:10240',
            'external_url' => 'nullable|url',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('icon')) {
            if ($portal_form->icon) Storage::disk('public')->delete($portal_form->icon);
            $validated['icon'] = $request->file('icon')->store('portal/icons', 'public');
        }

        if ($request->hasFile('file')) {
            if ($portal_form->file_path) Storage::disk('public')->delete($portal_form->file_path);
            $validated['file_path'] = $request->file('file')->store('portal/forms', 'public');
        }

        $portal_form->update($validated);

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form updated successfully.');
    }

    public function destroy(PortalForm $portal_form)
    {
        if ($portal_form->icon) Storage::disk('public')->delete($portal_form->icon);
        if ($portal_form->file_path) Storage::disk('public')->delete($portal_form->file_path);
        
        $portal_form->delete();

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form removed successfully.');
    }
}
