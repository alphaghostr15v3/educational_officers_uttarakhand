<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Circular;
use App\Models\SeniorityList;
use App\Models\News;

class EmployeeDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'pending_leaves' => \App\Models\Leave::where('user_id', $user->id)->where('status', 'pending')->count(),
            'pending_transfers' => \App\Models\Transfer::where('user_id', $user->id)->where('status', 'pending')->count(),
            'total_circulars' => Circular::where('is_published', true)->count(),
            'active_duties' => \App\Models\ElectionDuty::where('user_id', $user->id)->where('status', 'assigned')->count(),
        ];

        $recent_circulars = Circular::where('is_published', true)->latest()->take(5)->get();
        $recent_orders = Order::latest()->take(5)->get();
        $active_election_duties = \App\Models\ElectionDuty::where('user_id', $user->id)
            ->where('status', 'assigned')
            ->get();

        return view('employee.dashboard', compact('stats', 'recent_circulars', 'recent_orders', 'active_election_duties'));
    }
}
