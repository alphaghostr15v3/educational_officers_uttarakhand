<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalForm;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portal/icons'), $filename);
            $validated['icon'] = $filename;
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portal/forms'), $filename);
            $validated['file_path'] = $filename;
        }

        $form = PortalForm::create($validated);

        ActivityLogService::log('create', "Added portal form: {$form->title}", PortalForm::class, $form->id);

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form added successfully.');
    }

    public function edit(PortalForm $portal_form)
    {
        return view('admin.portal_forms.edit', compact('portal_form'));
    }

    public function update(Request $request, PortalForm $portalForm)
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
            if ($portalForm->icon) {
                $path = public_path('uploads/portal/icons/' . $portalForm->icon);
                if (File::exists($path)) File::delete($path);
            }
            $file = $request->file('icon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portal/icons'), $filename);
            $validated['icon'] = $filename;
        }

        if ($request->hasFile('file')) {
            if ($portalForm->file_path) {
                $path = public_path('uploads/portal/forms/' . $portalForm->file_path);
                if (File::exists($path)) File::delete($path);
            }
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/portal/forms'), $filename);
            $validated['file_path'] = $filename;
        }

        $portalForm->update($validated);

        ActivityLogService::log('update', "Updated portal form: {$portalForm->title}", PortalForm::class, $portalForm->id);

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form updated successfully.');
    }

    public function destroy(PortalForm $portalForm)
    {
        if ($portalForm->icon) {
            $path = public_path('uploads/portal/icons/' . $portalForm->icon);
            if (File::exists($path)) File::delete($path);
        }
        if ($portalForm->file_path) {
            $path = public_path('uploads/portal/forms/' . $portalForm->file_path);
            if (File::exists($path)) File::delete($path);
        }
        
        $title = $portalForm->title;
        $id = $portalForm->id;
        $portalForm->delete();

        ActivityLogService::log('delete', "Removed portal form: {$title}", PortalForm::class, $id);

        return redirect()->route('admin.portal-forms.index')->with('success', 'Portal form removed successfully.');
    }
}
