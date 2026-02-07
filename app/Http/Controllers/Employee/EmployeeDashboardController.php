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
        
        // Get recent items relevant to the employee
        $recent_orders = Order::orderBy('updated_at', 'desc')->limit(5)->get();
        $recent_news = News::orderBy('updated_at', 'desc')->limit(5)->get();
        
        $stats = [
            'total_orders' => Order::count(),
            'total_circulars' => Circular::count(),
            'total_seniority_lists' => SeniorityList::count(),
            'total_news' => News::count(),
        ];

        return view('employee.dashboard', compact('stats', 'recent_orders', 'recent_news'));
    }
}
