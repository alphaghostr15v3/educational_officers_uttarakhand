@extends('layouts.admin')

@section('page_title', isset($staff) ? 'Edit Staff Member' : 'Add New Staff')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-primary">
                    <i class="fas fa-{{ isset($staff) ? 'user-edit' : 'user-plus' }} me-2"></i>
                    {{ isset($staff) ? 'Edit Staff Profile' : 'Staff Basic Information' }}
                </h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($staff) ? route('admin.staff.update', $staff) : route('admin.staff.store') }}" method="POST">
                    @csrf
                    @if(isset($staff)) @method('PUT') @endif
                    <h6 class="fw-bold mb-3 text-primary">Personal Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', (isset($staff) && $staff->user) ? $staff->user->name : '') }}" required placeholder="Employee Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', (isset($staff) && $staff->user) ? $staff->user->email : '') }}" required placeholder="Official Email">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', (isset($staff) && $staff->user) ? $staff->user->mobile : '') }}" required placeholder="10-digit number">
                        </div>
                        @if(isset($staff) && $staff->id)
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Account Status <span class="text-danger">*</span></label>
                            <select name="current_status" class="form-select" required>
                                <option value="active" {{ $staff->current_status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $staff->current_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="on_leave" {{ $staff->current_status == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                                <option value="retired" {{ $staff->current_status == 'retired' ? 'selected' : '' }}>Retired</option>
                                <option value="transferred" {{ $staff->current_status == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="suspended" {{ $staff->current_status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <h6 class="fw-bold mb-3 text-primary">Service Details</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">School/Office <span class="text-danger">*</span></label>
                            <select name="school_id" class="form-select" required>
                                <option value="" disabled {{ !isset($staff) || !$staff->id ? 'selected' : '' }}>Select School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id', isset($staff) ? $staff->school_id : '') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Designation <span class="text-danger">*</span></label>
                            <select name="designation" class="form-select" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->name }}" {{ old('designation', isset($staff) ? $staff->designation : '') == $designation->name ? 'selected' : '' }}>
                                        {{ $designation->name }} ({{ ucfirst($designation->level) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Date of Joining <span class="text-danger">*</span></label>
                            <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', (isset($staff) && $staff->joining_date) ? $staff->joining_date->format('Y-m-d') : '') }}" required>
                        </div>
                    </div>

                    @if(!isset($staff))
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i> A user account will be automatically created with default password <strong>password123</strong>.
                    </div>
                    @endif

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">{{ isset($staff) ? 'Update Staff Record' : 'Create Staff Record' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
