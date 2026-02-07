<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
{
    $news = \App\Models\News::where('is_published', true)->where('is_ticker', true)->latest()->get();
    $recent_orders = \App\Models\Order::where('is_published', true)->latest()->take(5)->get();
    $portal_forms = \App\Models\PortalForm::where('is_active', true)->orderBy('sort_order')->get();
    $hero_slides = \App\Models\HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
    return view('public.home', compact('news', 'recent_orders', 'portal_forms', 'hero_slides'));
}
    public function officers()
    {
        $districts = \App\Models\District::all();
        $designations = \App\Models\Officer::distinct()->pluck('designation');
        $officers = \App\Models\Officer::with('district')->paginate(12);
        return view('public.officers.index', compact('districts', 'designations', 'officers'));
    }

    public function about()
    {
        return view('public.about');
    }

    public function orders()
    {
        $orders = \App\Models\Order::where('is_published', true)->latest()->paginate(20);
        return view('public.orders', compact('orders'));
    }

    public function seniority()
    {
        $lists = \App\Models\SeniorityList::where('is_published', true)->latest()->get();
        return view('public.seniority', compact('lists'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    public function donation()
    {
        $districts = \App\Models\District::all();
        return view('public.donation', compact('districts'));
    }

    public function processDonation(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'district_id' => 'required|exists:districts,id',
            'amount' => 'required|numeric|min:1',
            'purpose' => 'required|string',
        ]);

        $validated['receipt_number'] = 'UK-EDU-DON-' . strtoupper(\Illuminate\Support\Str::random(8));
        $validated['payment_status'] = 'completed'; // Mocking success
        $validated['payment_date'] = now();

        \App\Models\Donation::create($validated);

        return back()->with('success', 'Thank you for your contribution! Receipt No: ' . $validated['receipt_number']);
    }

    public function gallery()
    {
        $photos = \App\Models\Gallery::where('is_active', true)->latest()->paginate(16);
        return view('public.gallery', compact('photos'));
    }
}
