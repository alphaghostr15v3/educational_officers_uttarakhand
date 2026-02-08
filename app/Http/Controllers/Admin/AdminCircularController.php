<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Circular;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

class AdminCircularController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Circular::with(['uploadedBy', 'division', 'district']);

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id)->orWhere('level', 'state');
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id)->orWhere('level', 'state');
        }

        $circulars = $query->latest()->paginate(15);
        return view('admin.circulars.index', compact('circulars'));
    }

    public function create()
    {
        $divisions = Division::all();
        $districts = District::all();
        return view('admin.circulars.create', compact('divisions', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'circular_number' => 'required|string|unique:circulars',
            'circular_date' => 'required|date',
            'level' => 'required|in:state,division,district',
            'division_id' => 'nullable|required_if:level,division,district|exists:divisions,id',
            'district_id' => 'nullable|required_if:level,district|exists:districts,id',
            'file' => 'required|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/circulars'), $filename);
            $validated['file_path'] = $filename;
        }

        $validated['uploaded_by'] = auth()->id();
        return redirect()->route('admin.circulars.index')->with('success', 'Circular uploaded successfully.');
    }

    public function destroy(Circular $circular)
    {
        if ($circular->file_path) {
            $path = public_path('uploads/circulars/' . $circular->file_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        
        $circularNo = $circular->circular_number;
        $id = $circular->id;
        $circular->delete();

        ActivityLogService::log('delete', "Removed circular: {$circularNo}", Circular::class, $id);

        return redirect()->route('admin.circulars.index')->with('success', 'Circular removed successfully.');
    }
}
