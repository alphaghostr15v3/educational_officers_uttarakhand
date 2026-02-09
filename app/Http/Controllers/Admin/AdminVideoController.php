<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(15);
        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|string',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,qt|max:51200', // 50MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['video_file']); // We'll handle this separately
        $data['is_active'] = $request->has('is_active');

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/videos/files');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['video_file_path'] = $filename;
            $data['video_url'] = null; // Clear URL if file is uploaded
        }

        // Handle thumbnail upload using public_path
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/videos');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['thumbnail_path'] = $filename;
        }

        Video::create($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|string',
            'video_file' => 'nullable|mimes:mp4,mov,ogg,qt|max:51200', // 50MB
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['video_file']);
        $data['is_active'] = $request->has('is_active');

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video file if exists
            if ($video->video_file_path) {
                $oldVideoPath = public_path('uploads/videos/files/' . $video->video_file_path);
                if (file_exists($oldVideoPath)) {
                    unlink($oldVideoPath);
                }
            }

            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/videos/files');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['video_file_path'] = $filename;
            $data['video_url'] = null; // Clear URL if file is uploaded
        } elseif ($request->filled('video_url')) {
            // If URL is provided, delete old file
            if ($video->video_file_path) {
                $oldVideoPath = public_path('uploads/videos/files/' . $video->video_file_path);
                if (file_exists($oldVideoPath)) {
                    unlink($oldVideoPath);
                }
                $data['video_file_path'] = null;
            }
        }

        // Handle thumbnail upload using public_path
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($video->thumbnail_path) {
                $oldPath = public_path('uploads/videos/' . $video->thumbnail_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/videos');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['thumbnail_path'] = $filename;
        }

        $video->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        // Delete thumbnail file if exists
        if ($video->thumbnail_path) {
            $filePath = public_path('uploads/videos/' . $video->thumbnail_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete video file if exists
        if ($video->video_file_path) {
            $videoFilePath = public_path('uploads/videos/files/' . $video->video_file_path);
            if (file_exists($videoFilePath)) {
                unlink($videoFilePath);
            }
        }

        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully!');
    }

    /**
     * Toggle video active status
     */
    public function toggleStatus(Video $video)
    {
        $video->update(['is_active' => !$video->is_active]);
        
        $status = $video->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Video {$status} successfully!");
    }
}
