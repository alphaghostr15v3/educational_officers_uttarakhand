<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class EmployeeNotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = Notification::where(function($query) use ($user) {
                $query->where('target_role', 'all')
                      ->orWhere('target_role', 'officer')
                      ->orWhere('user_id', $user->id);
            })
            ->latest()
            ->paginate(15);

        return view('employee.notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === auth()->id() || $notification->target_role === 'all' || $notification->target_role === 'officer') {
            // In a real app, you might have a notification_user pivot table for 'all' notifications.
            // For now, let's just mark it if it's a direct notification.
            if ($notification->user_id === auth()->id()) {
                $notification->update(['is_read' => true]);
            }
        }
        return back();
    }
}
