<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\File;

class AdminNewsController extends Controller
{
    public function index()
    {
        // Only show non-ticker news items
        $news = News::where('is_ticker', false)
                    ->orWhereNull('is_ticker')
                    ->latest()
                    ->paginate(10);
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
            'publish_date' => 'required|date',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $validated['image'] = $filename;
        }

        $validated['created_by'] = auth()->id();
        $validated['is_published'] = true;
        $validated['is_ticker'] = false; // News items are never tickers

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
            'publish_date' => 'required|date',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($news->image) {
                $oldPath = public_path('uploads/news/' . $news->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $validated['image'] = $filename;
        }

        $validated['is_published'] = $request->has('is_published');
        $validated['is_ticker'] = false; // Ensure news items remain non-ticker

        $news->update($validated);

        ActivityLogService::log('update', "Updated news: {$news->title}", News::class, $news->id);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        $title = $news->title;
        $id = $news->id;
        
        if ($news->image) {
            $filePath = public_path('uploads/news/' . $news->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        $news->delete();

        ActivityLogService::log('delete', "Removed news item: {$title}", News::class, $id);
        return back()->with('success', 'News item removed.');
    }
}
