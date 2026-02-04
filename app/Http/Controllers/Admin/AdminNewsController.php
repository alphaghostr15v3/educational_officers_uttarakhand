<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\ActivityLogService;

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
            'is_ticker' => 'boolean',
            'publish_date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_published'] = true;

        $news = News::create($validated);

        ActivityLogService::log('create', "Published news: {$news->title}", News::class, $news->id);

        return redirect()->route('admin.news.index')->with('success', 'News published successfully.');
    }

    public function destroy(News $news)
    {
        $title = $news->title;
        $id = $news->id;
        $news->delete();

        ActivityLogService::log('delete', "Removed news item: {$title}", News::class, $id);
        return back()->with('success', 'News item removed.');
    }
}
