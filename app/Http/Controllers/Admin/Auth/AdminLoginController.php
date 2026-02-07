<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $user = Auth::user();
            
            // Ensure only users with admin roles can access
            if (in_array($user->role, ['state_admin', 'division_admin', 'district_admin'])) {
                $request->session()->regenerate();
                
                // Add success message
                session()->flash('success', 'Welcome back, ' . $user->name . '!');
                
                return redirect()->intended(route('admin.dashboard'));
            }

            // If not an admin, logout and throw error
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['These credentials do not have administrative access.'],
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
