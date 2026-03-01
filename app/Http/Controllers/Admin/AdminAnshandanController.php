<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anshandan;
use App\Models\User;
use App\Models\District;
use App\Models\Block;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminAnshandanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Anshandan::with(['user.staff.school', 'district.division', 'block', 'creator']);

        // Role-based filtering
        if ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        } elseif ($user->role === 'block_admin') {
            $query->where('block_id', $user->block_id);
        }

        // Additional filters
        if ($request->division_id) {
            $query->whereHas('district', function($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }
        if ($request->district_id) {
            $query->where('district_id', $request->district_id);
        }
        if ($request->block_id) {
            $query->where('block_id', $request->block_id);
        }
        if ($request->month) {
            $query->where('month', $request->month);
        }
        if ($request->year) {
            $query->where('year', $request->year);
        }

        // Calculate Stats (before pagination)
        $total_amount = (clone $query)->sum('amount');
        $provincial_share = $total_amount * 0.40;
        $mandal_share = $total_amount * 0.20;

        $anshandans = $query->latest()->paginate(75);
        $divisions = \App\Models\Division::all();
        $districts = $request->division_id 
            ? District::where('division_id', $request->division_id)->get() 
            : District::all();
        $blocks = $user->role === 'district_admin' 
            ? Block::where('district_id', $user->district_id)->get() 
            : ($user->role === 'block_admin' ? Block::where('id', $user->block_id)->get() : Block::all());

        return view('admin.anshandan.index', compact(
            'anshandans', 'divisions', 'districts', 'blocks', 
            'total_amount', 'provincial_share', 'mandal_share'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        $districts = District::all();
        $blocks = $user->role === 'district_admin' 
            ? Block::where('district_id', $user->district_id)->get() 
            : ($user->role === 'block_admin' ? Block::where('id', $user->block_id)->get() : Block::all());
        
        $members = User::where('role', 'member')
            ->with('staff.school')
            ->when($user->role === 'district_admin', function($q) use ($user) {
                return $q->where('district_id', $user->district_id);
            })
            ->when($user->role === 'block_admin', function($q) use ($user) {
                return $q->where('block_id', $user->block_id);
            })
            ->get();

        // Calculate next receipt number (numeric serial)
        $lastReceipt = Anshandan::whereRaw("receipt_no REGEXP '^[0-9]+$'")
            ->orderByRaw('CAST(receipt_no AS UNSIGNED) DESC')
            ->first();
        
        $schools = School::orderBy('name')->get();
        $nextReceiptNo = $lastReceipt ? (int)$lastReceipt->receipt_no + 1 : 1;

        return view('admin.anshandan.create', compact('districts', 'blocks', 'members', 'nextReceiptNo', 'schools'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'member_name' => 'required|string|max:255',
            'depositor_name' => 'required|string|max:255',
            'school_office' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'year' => 'required|integer',
            'payment_date' => 'required|date',
            'receipt_no' => 'required|string|unique:anshandans',
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'academic_year' => 'nullable|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'block_id' => 'nullable|exists:blocks,id',
            'remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('receipt_file')) {
            $file = $request->file('receipt_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/receipts'), $filename);
            $validated['receipt_file'] = 'uploads/receipts/' . $filename;
        }

        // Re-calculate next receipt number to ensure sequential integrity on save
        $lastReceipt = Anshandan::whereRaw("receipt_no REGEXP '^[0-9]+$'")
            ->orderByRaw('CAST(receipt_no AS UNSIGNED) DESC')
            ->first();
        $validated['receipt_no'] = $lastReceipt ? (int)$lastReceipt->receipt_no + 1 : 1;

        // Auto-assign jurisdiction for non-state admins
        if ($user->role === 'district_admin') {
            $validated['district_id'] = $user->district_id;
        } elseif ($user->role === 'block_admin') {
            $validated['district_id'] = $user->district_id;
            $validated['block_id'] = $user->block_id;
        }

        $validated['created_by'] = $user->id;

        Anshandan::create($validated);

        return redirect()->route('admin.anshandan.index')->with('success', 'Anshandan recorded successfully.');
    }

    public function show(Anshandan $anshandan)
    {
        $this->authorizeAccess($anshandan);
        $anshandan->load(['district', 'block', 'user.staff.school', 'creator']);
        return view('admin.anshandan.show', compact('anshandan'));
    }

    public function edit(Anshandan $anshandan)
    {
        $this->authorizeAccess($anshandan);

        $user = Auth::user();
        $districts = District::all();
        $blocks = $user->role === 'district_admin' 
            ? Block::where('district_id', $user->district_id)->get() 
            : ($user->role === 'block_admin' ? Block::where('id', $user->block_id)->get() : Block::all());
        
        $members = User::where('role', 'member')
            ->with('staff.school')
            ->when($user->role === 'district_admin', function($q) use ($user) {
                return $q->where('district_id', $user->district_id);
            })
            ->when($user->role === 'block_admin', function($q) use ($user) {
                return $q->where('block_id', $user->block_id);
            })
            ->get();

        $schools = School::orderBy('name')->get();

        return view('admin.anshandan.edit', compact('anshandan', 'districts', 'blocks', 'members', 'schools'));
    }

    public function update(Request $request, Anshandan $anshandan)
    {
        $this->authorizeAccess($anshandan);

        $user = Auth::user();
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'member_name' => 'required|string|max:255',
            'depositor_name' => 'required|string|max:255',
            'school_office' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'year' => 'required|integer',
            'payment_date' => 'required|date',
            'receipt_no' => 'required|string|unique:anshandans,receipt_no,' . $anshandan->id,
            'receipt_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'academic_year' => 'nullable|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'block_id' => 'nullable|exists:blocks,id',
            'remarks' => 'nullable|string',
        ]);

        if ($request->hasFile('receipt_file')) {
            // Delete old file if exists
            if ($anshandan->receipt_file && file_exists(public_path($anshandan->receipt_file))) {
                unlink(public_path($anshandan->receipt_file));
            }

            $file = $request->file('receipt_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/receipts'), $filename);
            $validated['receipt_file'] = 'uploads/receipts/' . $filename;
        }

        // Auto-assign jurisdiction for non-state admins
        if ($user->role === 'district_admin') {
            $validated['district_id'] = $user->district_id;
        } elseif ($user->role === 'block_admin') {
            $validated['district_id'] = $user->district_id;
            $validated['block_id'] = $user->block_id;
        }

        $anshandan->update($validated);

        return redirect()->route('admin.anshandan.index')->with('success', 'Anshandan updated successfully.');
    }

    public function destroy(Anshandan $anshandan)
    {
        $this->authorizeAccess($anshandan);
        $anshandan->delete();
        return redirect()->route('admin.anshandan.index')->with('success', 'Anshandan deleted successfully.');
    }

    public function downloadReceipt($id)
    {
        $anshandan = Anshandan::findOrFail($id);
        $this->authorizeAccess($anshandan);
        $anshandan->load(['district', 'block', 'user.staff.school', 'creator']);

        $pdf = Pdf::loadView('admin.anshandan.pdf_receipt', compact('anshandan'));
        return $pdf->download('Receipt-' . $anshandan->receipt_no . '.pdf');
    }

    protected function authorizeAccess(Anshandan $anshandan)
    {
        $user = Auth::user();
        if ($user->role === 'district_admin' && $anshandan->district_id !== $user->district_id) {
            abort(403);
        }
        if ($user->role === 'block_admin' && $anshandan->block_id !== $user->block_id) {
            abort(403);
        }
    }
}
