<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\SchoolDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SchoolDocumentController extends Controller
{
    public function index()
    {
        $documents = SchoolDocument::where('school_id', auth()->user()->school_id)->latest()->paginate(10);
        return view('school.documents.index', compact('documents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/school_documents'), $filename);

        SchoolDocument::create([
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filename,
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy(SchoolDocument $document)
    {
        if ($document->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        $filePath = public_path('uploads/school_documents/' . $document->file_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        
        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}
