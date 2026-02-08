<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\File;

class AdminTickerController extends Controller
{
    public function index()
    {
        $tickers = News::where('is_ticker', true)
                      ->orderBy('ticker_order', 'asc')
                      ->orderBy('created_at', 'desc')
                      ->paginate(15);
        
        return view('admin.ticker.index', compact('tickers'));
    }

    public function create()
    {
        return view('admin.ticker.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ticker_order' => 'nullable|integer|min:0',
            'publish_date' => 'required|date',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_published'] = true;
        $validated['is_ticker'] = true;
        $validated['content'] = $request->input('title'); // Use title as content for ticker

        $ticker = News::create($validated);

        ActivityLogService::log('create', "Created ticker: {$ticker->title}", News::class, $ticker->id);

        return redirect()->route('admin.ticker.index')->with('success', 'Ticker created successfully.');
    }

    public function edit(News $ticker)
    {
        // Ensure we're only editing ticker items
        if (!$ticker->is_ticker) {
            abort(404);
        }
        
        return view('admin.ticker.edit', compact('ticker'));
    }

    public function update(Request $request, News $ticker)
    {
        // Ensure we're only updating ticker items
        if (!$ticker->is_ticker) {
            abort(404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'ticker_order' => 'nullable|integer|min:0',
            'publish_date' => 'required|date',
        ]);

        $validated['content'] = $request->input('title'); // Keep content synced with title

        $ticker->update($validated);

        ActivityLogService::log('update', "Updated ticker: {$ticker->title}", News::class, $ticker->id);

        return redirect()->route('admin.ticker.index')->with('success', 'Ticker updated successfully.');
    }

    public function destroy(News $ticker)
    {
        // Ensure we're only deleting ticker items
        if (!$ticker->is_ticker) {
            abort(404);
        }

        $title = $ticker->title;
        $id = $ticker->id;
        
        if ($ticker->image) {
            $filePath = public_path('uploads/news/' . $ticker->image);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        
        $ticker->delete();

        ActivityLogService::log('delete', "Removed ticker: {$title}", News::class, $id);
        
        return back()->with('success', 'Ticker removed successfully.');
    }
    
    public function toggleStatus(News $ticker)
    {
        if (!$ticker->is_ticker) {
            abort(404);
        }

        $ticker->update(['is_published' => !$ticker->is_published]);
        
        ActivityLogService::log(
            'update', 
            "Toggled ticker status: {$ticker->title}", 
            News::class, 
            $ticker->id
        );
        
        return response()->json([
            'success' => true,
            'is_published' => $ticker->is_published,
            'message' => $ticker->is_published ? 'Ticker activated' : 'Ticker deactivated'
        ]);
    }
}
