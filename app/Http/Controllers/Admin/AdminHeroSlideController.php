<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

class AdminHeroSlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.hero_slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        return view('admin.hero_slides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hero_slides'), $filename);
            $validated['image_path'] = $filename;
        }

        $slide = HeroSlide::create($validated);
        ActivityLogService::log('create', "Added new hero slide: {$slide->title}", HeroSlide::class, $slide->id);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide added successfully.');
    }

    public function edit(HeroSlide $hero_slide)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        return view('admin.hero_slides.edit', compact('hero_slide'));
    }

    public function update(Request $request, HeroSlide $hero_slide)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'link' => 'nullable|url',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($hero_slide->image_path) {
                $oldPath = public_path('uploads/hero_slides/' . $hero_slide->image_path);
                if (File::exists($oldPath)) File::delete($oldPath);
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/hero_slides'), $filename);
            $validated['image_path'] = $filename;
        }

        $hero_slide->update($validated);
        ActivityLogService::log('update', "Updated hero slide: {$hero_slide->title}", HeroSlide::class, $hero_slide->id);

        return redirect()->route('admin.hero-slides.index')->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HeroSlide $hero_slide)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $title = $hero_slide->title;
        if ($hero_slide->image_path) {
            $path = public_path('uploads/hero_slides/' . $hero_slide->image_path);
            if (File::exists($path)) File::delete($path);
        }
        $hero_slide->delete();
        ActivityLogService::log('delete', "Deleted hero slide: {$title}", HeroSlide::class);

        return back()->with('success', 'Hero slide removed.');
    }
}
