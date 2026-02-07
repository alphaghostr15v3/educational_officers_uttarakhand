<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notification;
use App\Models\User;
use App\Services\ActivityLogService;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Notification::with('creator');

        if ($user->role !== 'state_admin') {
            $query->where('created_by', $user->id);
        }

        $notifications = $query->latest()->paginate(15);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'target_role' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $validated['created_by'] = auth()->id();

        $notification = Notification::create($validated);

        ActivityLogService::log('create', "Notification created: {$validated['title']}", Notification::class, $notification->id);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification sent successfully.');
    }

    public function destroy(Notification $notification)
    {
        // Only creator or state admin can delete
        if (auth()->id() !== $notification->created_by && auth()->user()->role !== 'state_admin') {
            abort(403);
        }

        $notification->delete();
        return redirect()->route('admin.notifications.index')->with('success', 'Notification deleted.');
    }
}
