<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ActivityLogService;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::latest()->paginate(12);
        return view('admin.gallery.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('gallery', 'public');
            $validated['image_path'] = $path;
        }

        $photo = Gallery::create([
            'title' => $validated['title'],
            'image_path' => $validated['image_path'],
            'category' => $validated['category'],
            'is_active' => true,
        ]);

        ActivityLogService::log('create', "Uploaded gallery photo: {$photo->title}", Gallery::class, $photo->id);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo uploaded successfully.');
    }

    public function toggleStatus(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        return back()->with('success', 'Photo status updated.');
    }

    public function destroy(Gallery $gallery)
    {
        $title = $gallery->title;
        $id = $gallery->id;

        if ($gallery->image_path) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        ActivityLogService::log('delete', "Deleted gallery photo: {$title}", Gallery::class, $id);

        return back()->with('success', 'Photo removed.');
    }
}
