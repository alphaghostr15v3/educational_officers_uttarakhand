<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!in_array($user->role, ['admin_panel', 'division_admin', 'district_admin', 'block_admin'])) {
            abort(403);
        }

        $query = ActivityLog::with('user');

        if ($user->role === 'division_admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('division_id', $user->division_id);
            });
        } elseif ($user->role === 'district_admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('district_id', $user->district_id);
            });
        } elseif ($user->role === 'block_admin') {
            $query->whereHas('user', function($q) use ($user) {
                $q->where('block_id', $user->block_id);
            });
        }

        $logs = $query->latest()->paginate(20);
        return view('admin.activity_logs.index', compact('logs'));
    }
}
