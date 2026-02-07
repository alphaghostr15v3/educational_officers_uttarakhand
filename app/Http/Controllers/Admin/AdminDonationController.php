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

        $stats = [
            'total_amount' => Donation::where('payment_status', 'completed')->sum('amount'),
            'total_count' => Donation::where('payment_status', 'completed')->count(),
            'pending_amount' => Donation::where('payment_status', 'pending')->sum('amount'),
            'district_total' => Donation::where('payment_status', 'completed')
                ->when($user->role !== 'state_admin', function($q) use ($user) {
                    return $q->where('district_id', $user->district_id);
                })
                ->sum('amount')
        ];

        return view('admin.donations.index', compact('donations', 'districts', 'stats'));
    }

    public function export()
    {
        $user = auth()->user();
        $query = Donation::with('district');

        if ($user->role === 'division_admin') {
            $districtIds = District::where('division_id', $user->division_id)->pluck('id');
            $query->whereIn('district_id', $districtIds);
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        }

        $donations = $query->get();
        $filename = "welfare_fund_report_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($donations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Receipt No', 'Donor Name', 'Mobile', 'District', 'Amount', 'Status', 'Date']);

            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->receipt_number,
                    $donation->donor_name,
                    $donation->mobile,
                    $donation->district->name ?? 'N/A',
                    $donation->amount,
                    $donation->payment_status,
                    $donation->created_at->format('Y-m-d')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
