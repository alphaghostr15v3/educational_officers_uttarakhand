<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        // Handle image upload using public_path
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/events');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['image_path'] = $filename;
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        // Handle image upload using public_path
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($event->image_path) {
                $oldPath = public_path('uploads/events/' . $event->image_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/events');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            $file->move($destinationPath, $filename);
            $data['image_path'] = $filename;
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete image file if exists
        if ($event->image_path) {
            $filePath = public_path('uploads/events/' . $event->image_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }

    /**
     * Toggle event active status
     */
    public function toggleStatus(Event $event)
    {
        $event->update(['is_active' => !$event->is_active]);
        
        $status = $event->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Event {$status} successfully!");
    }
}
