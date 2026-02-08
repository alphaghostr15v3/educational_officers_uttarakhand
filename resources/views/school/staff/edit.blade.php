@extends('layouts.school')

@section('title', 'Edit Staff')

@section('school_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Staff: {{ $staff->user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('school.staff.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('school.staff.update', $staff->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="card-title mb-4 text-primary">Personal & Service Details</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $staff->user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $staff->user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $staff->user->mobile) }}" required maxlength="10">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                            <select class="form-select @error('designation') is-invalid @enderror" id="designation" name="designation" required>
                                <option value="" disabled>Select Designation</option>
                                @php
                                    $designations = ['Principal', 'Lecturer', 'LT Grade', 'Clerk', 'Assistant Teacher', 'Senior Clerk', 'Administrative Officer'];
                                @endphp
                                @foreach($designations as $desig)
                                    <option value="{{ $desig }}" {{ old('designation', $staff->designation) == $desig ? 'selected' : '' }}>{{ $desig }}</option>
                                @endforeach
                            </select>
                            @error('designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="employee_code" class="form-label">Employee Code</label>
                            <input type="text" class="form-control @error('employee_code') is-invalid @enderror" id="employee_code" name="employee_code" value="{{ old('employee_code', $staff->user->employee_code) }}">
                             @error('employee_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="joining_date" class="form-label">Joining Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{ old('joining_date', $staff->joining_date ? $staff->joining_date->format('Y-m-d') : '') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="retirement_date" class="form-label">Retirement Date</label>
                            <input type="date" class="form-control @error('retirement_date') is-invalid @enderror" id="retirement_date" name="retirement_date" value="{{ old('retirement_date', $staff->retirement_date ? $staff->retirement_date->format('Y-m-d') : '') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Subject / Section</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" value="{{ old('subject', $staff->subject) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="current_status" class="form-label">Working Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('current_status') is-invalid @enderror" id="current_status" name="current_status" required>
                                <option value="active" {{ old('current_status', $staff->current_status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('current_status', $staff->current_status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="on_leave" {{ old('current_status', $staff->current_status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="transferred" {{ old('current_status', $staff->current_status) == 'transferred' ? 'selected' : '' }}>Transferred</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Update Staff Details</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
