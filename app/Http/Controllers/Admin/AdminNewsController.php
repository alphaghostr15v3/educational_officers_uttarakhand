<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Storage;

class AdminNewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_ticker' => 'boolean',
            'publish_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['created_by'] = auth()->id();
        $validated['is_published'] = true;
        
        // Handle boolean fields from checkboxes
        $validated['is_ticker'] = $request->has('is_ticker');

        $news = News::create($validated);

        ActivityLogService::log('create', "Published news: {$news->title}", News::class, $news->id);

        return redirect()->route('admin.news.index')->with('success', 'News published successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_ticker' => 'boolean',
            'publish_date' => 'required|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $validated['is_ticker'] = $request->has('is_ticker');
        $validated['is_published'] = $request->has('is_published');

        $news->update($validated);

        ActivityLogService::log('update', "Updated news: {$news->title}", News::class, $news->id);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        $title = $news->title;
        $id = $news->id;
        
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        ActivityLogService::log('delete', "Removed news item: {$title}", News::class, $id);
        return back()->with('success', 'News item removed.');
    }
}
