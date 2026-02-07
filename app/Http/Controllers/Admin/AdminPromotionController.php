<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;

class AdminPromotionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Promotion::with('user');

        // Role-based filtering
        if ($user->role === 'district_admin') {
            $query->pendingDistrict();
        } elseif ($user->role === 'division_admin') {
            $query->pendingDivision();
        } elseif ($user->role === 'state_admin') {
            // State admin can see all or just pending state (we'll show all for state admin but with specific focus)
            $query->latest();
        } else {
            // Other roles shouldn't access this normally, but let's be safe
            $query->where('status', Promotion::STATUS_APPROVED);
        }

        $promotions = $query->latest()->paginate(15);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        // Get employees to promote
        $users = User::where('role', 'employee')->get();
        return view('admin.promotions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_designation' => 'required|string',
            'promoted_designation' => 'required|string',
            'promotion_date' => 'required|date',
            'order_number' => 'nullable|string',
            'status' => 'required|in:pending,district_forwarded,division_recommended,approved,rejected',
            'file' => 'nullable|mimes:pdf|max:10240', // Order file
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_promo_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/promotions'), $filename);
            $validated['file_path'] = $filename;
        }

        $promotion = Promotion::create($validated);

        ActivityLogService::log('create', "Promotion record created for User ID: {$validated['user_id']}", Promotion::class, $promotion->id);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion record created successfully.');
    }

    public function updateStatus(Request $request, Promotion $promotion)
    {
        $user = auth()->user();
        $action = $request->input('action'); // forward, recommend, approve, reject
        
        $prevStatus = $promotion->status;

        if ($action === 'reject') {
            $promotion->update(['status' => Promotion::STATUS_REJECTED]);
            ActivityLogService::log('update', "Promotion rejected at {$user->role} level", Promotion::class, $promotion->id);
            return back()->with('success', 'Promotion rejected.');
        }

        if ($user->role === 'district_admin' && $promotion->status === Promotion::STATUS_PENDING) {
            $promotion->update(['status' => Promotion::STATUS_DISTRICT_FORWARDED]);
            ActivityLogService::log('update', "Promotion forwarded by District Admin", Promotion::class, $promotion->id);
            return back()->with('success', 'Promotion forwarded to Division.');
        }

        if ($user->role === 'division_admin' && $promotion->status === Promotion::STATUS_DISTRICT_FORWARDED) {
            $promotion->update(['status' => Promotion::STATUS_DIVISION_RECOMMENDED]);
            ActivityLogService::log('update', "Promotion recommended by Division Admin", Promotion::class, $promotion->id);
            return back()->with('success', 'Promotion recommended to State.');
        }

        if ($user->role === 'state_admin' && $promotion->status === Promotion::STATUS_DIVISION_RECOMMENDED) {
            $promotion->update(['status' => Promotion::STATUS_APPROVED]);

            // AUTOMATED DATA UPDATE: Update designation in Officers and Staffs tables
            \App\Models\Officer::where('user_id', $promotion->user_id)
                ->update(['designation' => $promotion->promoted_designation]);
            
            \App\Models\Staff::where('user_id', $promotion->user_id)
                ->update(['designation' => $promotion->promoted_designation]);

            ActivityLogService::log('update', "Promotion approved and designation updated", Promotion::class, $promotion->id);
            return back()->with('success', 'Promotion approved and designation updated successfully.');
        }

        return back()->with('error', 'Unauthorized action or invalid status.');
    }

    public function edit(Promotion $promotion)
    {
        if ($promotion->status !== Promotion::STATUS_PENDING && auth()->user()->role !== 'state_admin') {
            return redirect()->route('admin.promotions.index')->with('error', 'Only pending promotions can be edited.');
        }

        $users = User::where('role', 'employee')->get();
        return view('admin.promotions.edit', compact('promotion', 'users'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        if ($promotion->status !== Promotion::STATUS_PENDING && auth()->user()->role !== 'state_admin') {
            return redirect()->route('admin.promotions.index')->with('error', 'Only pending promotions can be updated.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_designation' => 'required|string',
            'promoted_designation' => 'required|string',
            'promotion_date' => 'required|date',
            'order_number' => 'nullable|string',
            'status' => 'required|in:pending,district_forwarded,division_recommended,approved,rejected',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($promotion->file_path && file_exists(public_path('uploads/promotions/'.$promotion->file_path))) {
                @unlink(public_path('uploads/promotions/'.$promotion->file_path));
            }
            
            $file = $request->file('file');
            $filename = time() . '_promo_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/promotions'), $filename);
            $validated['file_path'] = $filename;
        }

        $promotion->update($validated);

        ActivityLogService::log('update', "Updated promotion record for User ID: {$promotion->user_id}", Promotion::class, $promotion->id);

        return redirect()->route('admin.promotions.index')->with('success', 'Promotion record updated successfully.');
    }
}
