<?php

namespace App\Http\Controllers\School\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Division;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SchoolRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $divisions = Division::where('is_active', true)->get();
        $districts = District::where('is_active', true)->get();
        return view('school.auth.register', compact('divisions', 'districts'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            // 1. Create School
            $school = School::create([
                'name' => $request->school_name,
                'udise_code' => $request->udise_code,
                'type' => $request->type,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'block' => $request->block,
                'address' => $request->address,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_active' => true,
            ]);

            // 2. Create User linked to School
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'school',
                'school_id' => $school->id,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'is_active' => true,
            ]);

            DB::commit();

            Auth::login($user);

            return redirect()->route('school.dashboard')->with('success', 'School registered successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'school_name' => ['required', 'string', 'max:255'],
            'udise_code' => ['required', 'string', 'max:50', 'unique:schools'],
            'type' => ['required', 'in:primary,junior_high,secondary,senior_secondary,office'],
            'division_id' => ['required', 'exists:divisions,id'],
            'district_id' => ['required', 'exists:districts,id'],
            'block' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
