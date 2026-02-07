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
        if (in_array($user->role, ['state_admin', 'division_admin', 'district_admin'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('employee.dashboard');
    }
}
