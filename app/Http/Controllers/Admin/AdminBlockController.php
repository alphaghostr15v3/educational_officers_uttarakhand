<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\District;
use App\Services\ActivityLogService;

class AdminBlockController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $blocks = Block::with('district')->latest()->get();
        $districts = District::all();
        return view('admin.blocks.index', compact('blocks', 'districts'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:blocks,code',
        ]);

        $block = Block::create($validated);
        ActivityLogService::log('create', "Established new block: {$block->name}", Block::class, $block->id);
        return back()->with('success', 'Block established successfully.');
    }

    public function update(Request $request, Block $block)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $validated = $request->validate([
            'district_id' => 'required|exists:districts,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:blocks,code,' . $block->id,
        ]);

        $block->update($validated);
        ActivityLogService::log('update', "Updated block: {$block->name}", Block::class, $block->id);
        return back()->with('success', 'Block updated.');
    }

    public function destroy(Block $block)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $name = $block->name;
        $id = $block->id;
        $block->delete();
        ActivityLogService::log('delete', "Removed block: {$name}", Block::class, $id);
        return back()->with('success', 'Block removed.');
    }
}
