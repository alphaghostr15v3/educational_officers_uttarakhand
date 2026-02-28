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
        $user = auth()->user();
        if (!in_array($user->role, ['admin_panel', 'district_admin', 'block_admin'])) {
            abort(403);
        }
        
        $query = User::with(['division', 'district', 'block'])
            ->where('id', '!=', $user->id)
            ->latest();

        if ($user->role === 'district_admin') {
            $query->where('district_id', $user->district_id);
        } elseif ($user->role === 'block_admin') {
            $query->where('block_id', $user->block_id);
        }

        $users = $query->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = auth()->user();
        $divisions = [];
        $districts = [];
        $blocks = [];

        if ($user->role === 'admin_panel') {
            $divisions = Division::all();
            $districts = District::all();
            $blocks = \App\Models\Block::all();
        } elseif ($user->role === 'district_admin') {
            $divisions = Division::where('id', $user->division_id)->get();
            $districts = District::where('id', $user->district_id)->get();
            $blocks = \App\Models\Block::where('district_id', $user->district_id)->get();
        } elseif ($user->role === 'block_admin') {
            $divisions = Division::where('id', $user->division_id)->get();
            $districts = District::where('id', $user->district_id)->get();
            $blocks = \App\Models\Block::where('id', $user->block_id)->get();
        }

        return view('admin.users.create', compact('divisions', 'districts', 'blocks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:division_admin,district_admin,admin_panel,block_admin',
            'division_id' => 'nullable|exists:divisions,id',
            'district_id' => 'nullable|exists:districts,id',
            'block_id' => 'nullable|exists:blocks,id',
        ]);

        $user = auth()->user();
        
        // Ensure non-admin panels create users within their jurisdiction
        if ($user->role === 'district_admin') {
            $validated['district_id'] = $user->district_id;
            $validated['division_id'] = $user->division_id;
            if ($validated['role'] === 'admin_panel' || $validated['role'] === 'division_admin') {
                abort(403, 'You cannot create a user with a higher role than yours.');
            }
        } elseif ($user->role === 'block_admin') {
            $validated['block_id'] = $user->block_id;
            $validated['district_id'] = $user->district_id;
            $validated['division_id'] = $user->division_id;
             if (in_array($validated['role'], ['admin_panel', 'division_admin', 'district_admin'])) {
                abort(403, 'You can only create users within your block.');
            }
        }

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Admin user created successfully.');
    }

    public function destroy(User $user)
    {
        $admin = auth()->user();
        
        // Authorization check
        if ($admin->role === 'admin_panel') {
            // Admin panel can delete anyone except themselves (handled by index filter usually)
        } elseif ($admin->role === 'district_admin') {
            if ($user->district_id !== $admin->district_id || $user->role === 'admin_panel' || $user->role === 'division_admin') {
                abort(403, 'You can only delete users within your district.');
            }
        } elseif ($admin->role === 'block_admin') {
            if ($user->block_id !== $admin->block_id || in_array($user->role, ['admin_panel', 'division_admin', 'district_admin'])) {
                abort(403, 'You can only delete users within your block.');
            }
        } else {
            abort(403);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
