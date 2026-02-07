<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class MemberLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/employee/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('employee.auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        // if (!$user->is_active) {
        //     auth()->logout();
        //     return back()->with('error', 'Your account is not active yet. Please contact the administrator.');
        // }

        return redirect()->intended($this->redirectPath());
    }
}
