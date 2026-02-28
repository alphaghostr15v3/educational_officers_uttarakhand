<?php

namespace App\Http\Controllers\StateAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StateAdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_help' => \App\Models\HelpRequest::where('target_level', 'state')->where('status', 'pending')->count(),
            'total_help' => \App\Models\HelpRequest::where('target_level', 'state')->count(),
        ];
        return view('state-admin.dashboard', compact('stats'));
    }
}
