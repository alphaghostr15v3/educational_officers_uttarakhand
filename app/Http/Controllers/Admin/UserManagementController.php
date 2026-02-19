<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        
        $users = User::with(['division', 'district', 'block'])
            ->where('id', '!=', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $divisions = \App\Models\Division::all();
        $districts = \App\Models\District::all();
        $blocks = \App\Models\Block::all();
        return view('admin.users.create', compact('divisions', 'districts', 'blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:division_admin,district_admin,state_admin,block_admin',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'block_id' => 'nullable|exists:blocks,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'state_admin') abort(403);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
