<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MemberRegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/employee/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $divisions = Division::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();
        return view('employee.auth.register', compact('divisions', 'districts'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'employee_code' => ['required', 'string', 'max:50', 'unique:users'],
            'mobile' => ['required', 'string', 'max:15'],
            'division_id' => ['required', 'exists:divisions,id'],
            'district_id' => ['required', 'exists:districts,id'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'officer', // Default role for members as per migration logic
            'employee_code' => $data['employee_code'],
            'mobile' => $data['mobile'],
            'division_id' => $data['division_id'],
            'district_id' => $data['district_id'],
            'is_active' => false, // Require admin activation
        ]);
    }
}
