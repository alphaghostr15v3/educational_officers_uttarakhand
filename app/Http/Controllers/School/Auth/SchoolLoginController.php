<?php

namespace App\Http\Controllers\School\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class SchoolLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/school/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('school.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role !== 'school') {
            auth()->logout();
            return back()->with('error', 'Access denied. This portal is for School logins only.');
        }
        
        return redirect()->intended($this->redirectPath());
    }
}
