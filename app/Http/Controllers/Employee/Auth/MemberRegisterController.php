<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\School;
use App\Models\Staff;
use App\Models\Designation;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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
        $schools = School::where('is_active', true)->orderBy('name')->get();
        $designations = Designation::where('is_active', true)->orderBy('level')->orderBy('order')->get();
        return view('employee.auth.register', compact('divisions', 'districts', 'schools', 'designations'));
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
            'designation' => ['required', 'string', 'max:255'],
            'school_id' => ['required', 'exists:schools,id'],
            'joining_date' => ['required', 'date'],
        ]);
    }

    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'officer',
                'employee_code' => $data['employee_code'],
                'mobile' => $data['mobile'],
                'division_id' => $data['division_id'],
                'district_id' => $data['district_id'],
                'school_id' => $data['school_id'],
                'is_active' => true,
            ]);

            Staff::create([
                'user_id' => $user->id,
                'school_id' => $data['school_id'],
                'designation' => $data['designation'],
                'joining_date' => $data['joining_date'],
                'current_status' => 'active',
            ]);

            return $user;
        });
    }
}
