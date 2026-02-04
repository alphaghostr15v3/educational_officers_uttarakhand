<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Services\ActivityLogService;

class FrontendAdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        return view('admin.frontend.dashboard');
    }

    public function slider()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $slides = HeroSlide::orderBy('sort_order')->get();
        return view('admin.frontend.slider.index', compact('slides'));
    }

    public function createSlide()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        return view('admin.frontend.slider.create');
    }

    public function editSlide(HeroSlide $hero_slide)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        return view('admin.frontend.slider.edit', compact('hero_slide'));
    }
}
