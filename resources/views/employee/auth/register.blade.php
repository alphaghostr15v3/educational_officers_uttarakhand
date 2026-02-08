@extends('layouts.public')

@section('content')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #1a5c96 0%, #003057 100%);
        --accent-color: #FF9933;
    }

    body {
        background-color: #f0f2f5;
        overflow-x: hidden;
    }

    .register-container {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .register-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        width: 100%;
        max-width: 1100px;
        min-height: 700px;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .register-sidebar {
        flex: 0 0 40%;
        background: url('{{ asset("images/about_association.png") }}');
        background-size: cover;
        background-position: center;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .register-sidebar::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(26, 92, 150, 0.85), rgba(0, 48, 87, 0.95));
        z-index: 1;
    }

    .register-sidebar-content {
        position: relative;
        z-index: 10;
    }

    .register-sidebar h2 {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .register-sidebar p {
        font-size: 1rem;
        opacity: 0.9;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .register-form-section {
        flex: 1;
        padding: 3rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: #fff;
    }

    .form-header {
        margin-bottom: 2rem;
    }

    .form-header h3 {
        font-weight: 700;
        color: #1a5c96;
        margin-bottom: 0.5rem;
    }

    .form-control-custom {
        border: 2px solid #eef0f2;
        border-radius: 10px;
        padding: 0.7rem 1.2rem;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .form-control-custom:focus {
        border-color: #1a5c96;
        box-shadow: 0 0 0 4px rgba(26, 92, 150, 0.1);
        outline: none;
    }

    .form-select-custom {
        border: 2px solid #eef0f2;
        border-radius: 10px;
        padding: 0.7rem 1.2rem;
        transition: all 0.3s;
        font-size: 0.95rem;
        cursor: pointer;
    }

    .form-select-custom:focus {
        border-color: #1a5c96;
        box-shadow: 0 0 0 4px rgba(26, 92, 150, 0.1);
        outline: none;
    }

    .btn-register {
        background: var(--primary-gradient);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(26, 92, 150, 0.2);
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(26, 92, 150, 0.3);
        color: #fff;
    }

    @media (max-width: 991px) {
        .register-sidebar { display: none; }
        .register-card { max-width: 600px; }
        .register-form-section { padding: 3rem 2rem; }
    }

    .step-indicator {
        display: flex;
        margin-bottom: 2rem;
        gap: 0.5rem;
    }

    .step {
        height: 4px;
        flex: 1;
        background: #eef0f2;
        border-radius: 2px;
    }

    .step.active {
        background: var(--accent-color);
    }
</style>

<div class="register-container">
    <div class="register-card">
        <!-- Sidebar -->
        <div class="register-sidebar">
            <div class="register-sidebar-content">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" 
                     alt="UK Logo" style="height: 70px; margin-bottom: 2rem;">
                <h2>Join Our Member Community</h2>
                <p>Register to access exclusive departmental resources, track your seniority, and stay updated with the latest notifications from the Educational Ministerial Officers Association Uttarakhand.</p>
                
                <div class="features mt-4">
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-file-invoice text-white small"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Departmental Records</h6>
                            <small class="opacity-75">Access official documents and forms</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-chart-line text-white small"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Career Management</h6>
                            <small class="opacity-75">Monitor seniority and promotion lists</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-white bg-opacity-20 rounded-circle p-2 me-3 mt-1">
                            <i class="fas fa-bell text-white small"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Real-time Updates</h6>
                            <small class="opacity-75">Get instant notifications on associations news</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="register-form-section">
            <div class="form-header">
                <h3>Create Your Account</h3>
                <p class="text-muted">Fill in your professional details to get started.</p>
            </div>

            <form method="POST" action="{{ route('employee.register') }}">
                @csrf

                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Full Name</label>
                        <input id="name" type="text" class="form-control-custom w-100 @error('name') is-invalid @enderror" 
                               name="name" value="{{ old('name') }}" required placeholder="e.g. Rahul Sharma">
                        @error('name')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Email Address</label>
                        <input id="email" type="email" class="form-control-custom w-100 @error('email') is-invalid @enderror" 
                               name="email" value="{{ old('email') }}" required placeholder="name@email.com">
                        @error('email')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Employee Code -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Employee Code</label>
                        <input id="employee_code" type="text" class="form-control-custom w-100 @error('employee_code') is-invalid @enderror" 
                               name="employee_code" value="{{ old('employee_code') }}" required placeholder="EMP12345">
                        @error('employee_code')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Mobile Number</label>
                        <input id="mobile" type="text" class="form-control-custom w-100 @error('mobile') is-invalid @enderror" 
                               name="mobile" value="{{ old('mobile') }}" required placeholder="+91 00000 00000">
                        @error('mobile')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Division -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Division</label>
                        <select id="division_id" class="form-select-custom w-100 @error('division_id') is-invalid @enderror" name="division_id" required>
                            <option value="">Select Division</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- District -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">District</label>
                        <select id="district_id" class="form-select-custom w-100 @error('district_id') is-invalid @enderror" name="district_id" required>
                            <option value="">Select District</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- School -->
                    <div class="col-md-12 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Current School/Office</label>
                        <select id="school_id" class="form-select-custom w-100 @error('school_id') is-invalid @enderror" name="school_id" required>
                            <option value="">Select School/Office</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }} data-district="{{ $school->district_id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        @error('school_id')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Designation -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Current Designation</label>
                        <select id="designation" class="form-select-custom w-100 @error('designation') is-invalid @enderror" name="designation" required>
                            <option value="">Select Designation</option>
                            @foreach($designations as $designation)
                                <option value="{{ $designation->name }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>
                                    {{ $designation->name }} ({{ ucfirst($designation->level) }})
                                </option>
                            @endforeach
                        </select>
                        @error('designation')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Date of Joining -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Date of Joining</label>
                        <input id="joining_date" type="date" class="form-control-custom w-100 @error('joining_date') is-invalid @enderror" 
                               name="joining_date" value="{{ old('joining_date') }}" required>
                        @error('joining_date')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Password</label>
                        <input id="password" type="password" class="form-control-custom w-100 @error('password') is-invalid @enderror" 
                               name="password" required placeholder="Min. 8 characters">
                        @error('password')
                            <span class="invalid-feedback d-block mt-1"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold small text-muted text-uppercase">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control-custom w-100" 
                               name="password_confirmation" required placeholder="Repeat password">
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-register">
                        Complete Registration
                    </button>
                </div>

                <div class="mt-4 text-center">
                    <p class="mb-0 text-muted small">Already a member? <a href="{{ route('employee.login') }}" class="fw-bold text-decoration-none" style="color: #1a5c96;">Sign In</a></p>
                </div>
            </form>
            
            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted small"><i class="fas fa-arrow-left me-1"></i> Back to Homepage</a>
            </div>
        </div>
    </div>
</div>

<script>
    const districts = @json($districts);
    const schools = @json($schools);

    document.getElementById('division_id').addEventListener('change', function() {
        const divisionId = this.value;
        const districtSelect = document.getElementById('district_id');
        const schoolSelect = document.getElementById('school_id');
        
        districtSelect.innerHTML = '<option value="">Select District</option>';
        schoolSelect.innerHTML = '<option value="">Select School/Office</option>';
        
        if (divisionId) {
            const filteredDistricts = districts.filter(d => d.division_id == divisionId);
            filteredDistricts.forEach(district => {
                const option = document.createElement('option');
                option.value = district.id;
                option.textContent = district.name;
                districtSelect.appendChild(option);
            });
        }
    });

    document.getElementById('district_id').addEventListener('change', function() {
        const districtId = this.value;
        const schoolSelect = document.getElementById('school_id');
        
        schoolSelect.innerHTML = '<option value="">Select School/Office</option>';
        
        if (districtId) {
            const filteredSchools = schools.filter(s => s.district_id == districtId);
            filteredSchools.forEach(school => {
                const option = document.createElement('option');
                option.value = school.id;
                option.textContent = school.name;
                schoolSelect.appendChild(option);
            });
        }
    });
</script>
@endsection
