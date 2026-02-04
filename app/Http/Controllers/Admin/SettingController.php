<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\ActivityLogService;

class SettingController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        ActivityLogService::log('update', "Updated system configuration settings", Setting::class);

        return back()->with('success', 'System settings updated successfully.');
    }
}
