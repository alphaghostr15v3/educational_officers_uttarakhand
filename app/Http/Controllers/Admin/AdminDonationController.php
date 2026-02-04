<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\District;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Donation::with('district');

        if ($user->role === 'division_admin') {
            $districtIds = District::where('division_id', $user->division_id)->pluck('id');
            $query->whereIn('district_id', $districtIds);
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        }

        // Filters
        if ($request->district_id) {
            $query->where('district_id', $request->district_id);
        }
        if ($request->status) {
            $query->where('payment_status', $request->status);
        }

        $donations = $query->latest()->paginate(15);
        $districts = District::all();

        return view('admin.donations.index', compact('donations', 'districts'));
    }

    public function show(Donation $donation)
    {
        return view('admin.donations.show', compact('donation'));
    }
}
