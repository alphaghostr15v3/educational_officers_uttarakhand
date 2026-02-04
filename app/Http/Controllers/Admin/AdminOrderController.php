<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

class AdminOrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Order::with(['division', 'district', 'uploader']);

        if ($user->role === 'division_admin') {
            $query->where('division_id', $user->division_id)->orWhere('level', 'state');
        } elseif ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id)
                  ->orWhere('division_id', $user->division_id)
                  ->orWhere('level', 'state');
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $divisions = Division::all();
        $districts = District::all();
        return view('admin.orders.create', compact('divisions', 'districts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'order_number' => 'required|string|unique:orders,order_number',
            'order_date' => 'required|date',
            'category' => 'required|in:transfer,promotion,govt_order,notice',
            'level' => 'required|in:state,division,district',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'file' => 'required|mimes:pdf|max:10240',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/orders'), $filename);
            $validated['file_path'] = $filename;
        }

        $validated['uploaded_by'] = auth()->id();
        $order = Order::create($validated);

        ActivityLogService::log('create', "Uploaded new order: {$order->order_number} - {$order->title}", Order::class, $order->id);

        return redirect()->route('admin.orders.index')->with('success', 'Order uploaded successfully.');
    }

    public function destroy(Order $order)
    {
        if ($order->file_path) {
            $path = public_path('uploads/orders/' . $order->file_path);
            if (File::exists($path)) File::delete($path);
        }
        $title = $order->title;
        $id = $order->id;
        $order->delete();

        ActivityLogService::log('delete', "Deleted order: {$title}", Order::class, $id);
        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
