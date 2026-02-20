@extends('layouts.admin')

@section('page_title', 'Add New Employee')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="fas fa-user-plus me-2"></i>Employee Details & Account</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Account Information -->
                        <div class="col-12">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Basic Information</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Enter full name">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                            <div class="form-text small">Max size: 2MB (JPEG, PNG, JPG)</div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Employee Code (Unique)</label>
                            <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code') }}" required placeholder="e.g. EMP12345">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@example.com">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}" required placeholder="10-digit mobile number">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                        </div>
                        <!-- Professional Details -->
                        <div class="col-12 mt-5">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Professional Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Designation</label>
                            <select name="designation" class="form-select" required>
                                <option value="">-- Select Designation --</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->name }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>{{ $designation->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Date of Joining</label>
                            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Assign School / Office</label>
                            <select name="school_id" class="form-select" required>
                                <option value="">-- Select School --</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }} ({{ $school->udise_code }})</option>
                                @endforeach
                            </select>
                            <div class="form-text small">Only schools/offices in your jurisdiction are listed.</div>
                        </div>

                        {{-- Default Password Notice --}}
                        <div class="col-12 mt-3">
                            <div class="alert alert-info small mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                A login account will be created automatically with default password:
                                <strong>{{ auth()->user()->role === 'block_admin' ? 'block@123' : 'district@123' }}</strong>.
                                Please share this with the employee.
                            </div>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top text-end">
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                            <button type="submit" class="btn btn-dark px-5 fw-bold">Save Employee Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
