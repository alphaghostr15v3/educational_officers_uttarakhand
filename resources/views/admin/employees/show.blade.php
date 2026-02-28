@extends('layouts.admin')

@section('page_title', 'Employee Profile')

@section('admin_content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center py-4">
                <img src="{{ $employee->image_url }}" class="rounded-circle mb-3 border p-1" style="width: 120px; height: 120px; object-fit: cover;">
                <h5 class="fw-bold mb-1">{{ $employee->name }}</h5>
                <span class="badge bg-primary-subtle text-primary mb-3">{{ $employee->designation }}</span>
                <p class="text-muted small mb-0">{{ $employee->employee_code }}</p>
            </div>
            <div class="card-footer bg-white p-0">
                <div class="row g-0">
                    <div class="col-6 border-end p-3 text-center">
                        <small class="text-muted d-block uppercase mb-1" style="font-size: 0.65rem;">Joined On</small>
                        <div class="fw-bold small">{{ $employee->staff->joining_date ? $employee->staff->joining_date->format('d M, Y') : 'N/A' }}</div>
                    </div>
                     <div class="col-6 p-3 text-center">
                        <small class="text-muted d-block uppercase mb-1" style="font-size: 0.65rem;">Status</small>
                        <span class="badge bg-success small">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold small">Contact Information</div>
            <div class="card-body">
                <div class="d-flex mb-3">
                    <i class="fas fa-envelope text-muted me-3 mt-1"></i>
                    <div>
                        <div class="small fw-bold">Email</div>
                        <div class="text-muted small">{{ $employee->email }}</div>
                    </div>
                </div>
                <div class="d-flex mb-0">
                    <i class="fas fa-phone text-muted me-3 mt-1"></i>
                    <div>
                        <div class="small fw-bold">Mobile</div>
                        <div class="text-muted small">{{ $employee->mobile ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
             <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Employment Details</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="text-muted small d-block mb-1">Current School / Office</label>
                        <div class="fw-bold">{{ $employee->staff->school->name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block mb-1">Designation</label>
                        <div class="fw-bold">{{ $employee->designation }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block mb-1">Block</label>
                        <div class="fw-bold">{{ $employee->block->name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small d-block mb-1">District</label>
                        <div class="fw-bold">{{ $employee->district->name ?? 'N/A' }}</div>
                    </div>
                   <div class="col-md-6">
                        <label class="text-muted small d-block mb-1">Division</label>
                        <div class="fw-bold">{{ $employee->division->name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                         <label class="text-muted small d-block mb-1">Date of Birth</label>
                        <div class="fw-bold">{{ $employee->dob ? $employee->dob->format('d M, Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Quick Links</h6>
            </div>
            <div class="card-body p-4">
                <div class="row g-2">
                    <div class="col-md-4">
                        <a href="{{ route('admin.leaves.index', ['user_id' => $employee->id]) }}" class="btn btn-outline-info w-100 btn-sm py-2">
                            <i class="fas fa-calendar-check me-2"></i> Leave History
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-outline-primary w-100 btn-sm py-2">
                            <i class="fas fa-user-edit me-2"></i> Edit Profile
                        </a>
                    </div>
                    @if($employee->staff)
                    <div class="col-md-4">
                        <a href="{{ route('admin.staff.edit', $employee->staff->id) }}" class="btn btn-outline-secondary w-100 btn-sm py-2">
                            <i class="fas fa-file-invoice me-2"></i> Edit Service Record
                        </a>
                    </div>
                    @endif
                    @if(auth()->user()->role === 'admin_panel')
                    <div class="col-md-4">
                        <a href="{{ route('admin.users.index', ['search' => $employee->email]) }}" class="btn btn-outline-dark w-100 btn-sm py-2">
                            <i class="fas fa-key me-2"></i> Manage Account
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-2">
    <a href="{{ route('admin.employees.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-2"></i> Back to List</a>
</div>
@endsection
