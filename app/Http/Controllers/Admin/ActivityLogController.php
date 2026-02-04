<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.activity_logs.index', compact('logs'));
    }
}
