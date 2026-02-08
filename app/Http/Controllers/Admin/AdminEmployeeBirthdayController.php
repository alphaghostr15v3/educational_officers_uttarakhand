<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmployeeBirthday;
use App\Models\Designation;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

class AdminEmployeeBirthdayController extends Controller
{
    public function index()
    {
        $birthdays = EmployeeBirthday::latest()->paginate(10);
        return view('admin.birthdays.index', compact('birthdays'));
    }

    public function create()
    {
        $designations = Designation::where('is_active', true)->orderBy('level')->orderBy('order')->get();
        return view('admin.birthdays.create', compact('designations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'dob' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/birthdays'), $filename);
            $validated['photo'] = $filename;
        }

        $birthday = EmployeeBirthday::create($validated);

        ActivityLogService::log('create', "Added birthday entry for: {$birthday->name}", EmployeeBirthday::class, $birthday->id);

        return redirect()->route('admin.birthdays.index')->with('success', 'Birthday entry added successfully.');
    }

    public function edit(EmployeeBirthday $birthday)
    {
        $designations = Designation::where('is_active', true)->orderBy('level')->orderBy('order')->get();
        return view('admin.birthdays.edit', compact('birthday', 'designations'));
    }

    public function update(Request $request, EmployeeBirthday $birthday)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'dob' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('photo')) {
            if ($birthday->photo) {
                $oldPath = public_path('uploads/birthdays/' . $birthday->photo);
                if (File::exists($oldPath)) File::delete($oldPath);
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/birthdays'), $filename);
            $validated['photo'] = $filename;
        }

        $birthday->update($validated);

        ActivityLogService::log('update', "Updated birthday entry for: {$birthday->name}", EmployeeBirthday::class, $birthday->id);

        return redirect()->route('admin.birthdays.index')->with('success', 'Birthday entry updated successfully.');
    }

    public function destroy(EmployeeBirthday $birthday)
    {
        if ($birthday->photo) {
            $path = public_path('uploads/birthdays/' . $birthday->photo);
            if (File::exists($path)) File::delete($path);
        }
        
        $name = $birthday->name;
        $id = $birthday->id;
        $birthday->delete();

        ActivityLogService::log('delete', "Removed birthday entry for: {$name}", EmployeeBirthday::class, $id);

        return redirect()->route('admin.birthdays.index')->with('success', 'Birthday entry deleted successfully.');
    }

    public function toggleStatus(EmployeeBirthday $birthday)
    {
        $birthday->is_active = !$birthday->is_active;
        $birthday->save();

        ActivityLogService::log('update', "Toggled status for birthday entry: {$birthday->name}", EmployeeBirthday::class, $birthday->id);

        return response()->json(['success' => true]);
    }
}
