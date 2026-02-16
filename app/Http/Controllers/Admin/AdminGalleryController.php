<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

use App\Models\GalleryPhoto;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $photos = Gallery::with('photos')->latest()->paginate(12);
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
            'inner_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $validated['image_path'] = $filename;
        }

        $photo = Gallery::create([
            'title' => $validated['title'],
            'image_path' => $validated['image_path'],
            'category' => $validated['category'],
            'is_active' => true,
        ]);

        if ($request->hasFile('inner_photos')) {
            foreach ($request->file('inner_photos') as $innerFile) {
                $innerFilename = time() . '_inner_' . $innerFile->getClientOriginalName();
                $innerFile->move(public_path('uploads/gallery'), $innerFilename);
                $photo->photos()->create(['photo_path' => $innerFilename]);
            }
        }

        ActivityLogService::log('create', "Uploaded gallery photo: {$photo->title} with " . ($request->hasFile('inner_photos') ? count($request->file('inner_photos')) : 0) . " inner photos", Gallery::class, $photo->id);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo and album uploaded successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('photos');
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'inner_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old cover image
            if ($gallery->image_path) {
                $oldPath = public_path('uploads/gallery/' . $gallery->image_path);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/gallery'), $filename);
            $gallery->image_path = $filename;
        }

        $gallery->title = $validated['title'];
        $gallery->category = $validated['category'];
        $gallery->save();

        if ($request->hasFile('inner_photos')) {
            foreach ($request->file('inner_photos') as $innerFile) {
                $innerFilename = time() . '_inner_' . $innerFile->getClientOriginalName();
                $innerFile->move(public_path('uploads/gallery'), $innerFilename);
                $gallery->photos()->create(['photo_path' => $innerFilename]);
            }
        }

        ActivityLogService::log('update', "Updated gallery photo: {$gallery->title}", Gallery::class, $gallery->id);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function deletePhoto(GalleryPhoto $photo)
    {
        $galleryId = $photo->gallery_id;
        $filePath = public_path('uploads/gallery/' . $photo->photo_path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $photo->delete();

        return back()->with('success', 'Inner photo removed.');
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

        // Delete main image
        if ($gallery->image_path) {
            $filePath = public_path('uploads/gallery/' . $gallery->image_path);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        // Delete inner photos and their files
        foreach ($gallery->photos as $photo) {
            $innerFilePath = public_path('uploads/gallery/' . $photo->photo_path);
            if (File::exists($innerFilePath)) {
                File::delete($innerFilePath);
            }
            $photo->delete();
        }

        $gallery->delete();

        ActivityLogService::log('delete', "Deleted gallery photo: {$title}", Gallery::class, $id);

        return back()->with('success', 'Photo and its album removed.');
    }
}
