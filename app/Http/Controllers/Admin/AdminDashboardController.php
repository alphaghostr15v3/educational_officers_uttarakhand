<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Officer;
use App\Models\Order;
use App\Models\Donation;
use App\Models\User;
use App\Models\Election;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Base counts with role filtering
        $officerQuery = Officer::query();
        $orderQuery = Order::query();
        $donationQuery = Donation::query();
        $userQuery = User::query();

        if ($user->role === 'division_admin') {
            $officerQuery->where('division_id', $user->division_id);
            $orderQuery->where('division_id', $user->division_id);
            $userQuery->where('division_id', $user->division_id);
            // Donations are currently district-linked, need to join or filter by districts in division
            $districtIds = \App\Models\District::where('division_id', $user->division_id)->pluck('id');
            $donationQuery->whereIn('district_id', $districtIds);
        } elseif ($user->role === 'district_admin') {
            $officerQuery->where('district_id', $user->district_id);
            $orderQuery->where('district_id', $user->district_id);
            $donationQuery->where('district_id', $user->district_id);
            $userQuery->where('district_id', $user->district_id);
        }

        $stats = [
            'officers_count' => $officerQuery->count(),
            'orders_count' => $orderQuery->count(),
            'donations_total' => $donationQuery->where('payment_status', 'completed')->sum('amount'),
            'users_count' => $userQuery->count(),
            'active_elections' => Election::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
