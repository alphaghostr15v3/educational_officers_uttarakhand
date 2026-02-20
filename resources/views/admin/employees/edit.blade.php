@extends('layouts.admin')

@section('page_title', 'Edit Employee Profile')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="fas fa-user-edit me-2"></i>Edit Employee Profile</h6>
                <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-light border">
                    <i class="fas fa-arrow-left me-1"></i> Back to Profile
                </a>
            </div>
            <div class="card-body p-4">

                @if($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Basic Info --}}
                        <div class="col-12">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Basic Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Employee Code</label>
                            <input type="text" name="employee_code" class="form-control" value="{{ old('employee_code', $employee->employee_code) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $employee->mobile) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob', $employee->dob?->format('Y-m-d')) }}">
                        </div>
                        {{-- Profile Picture --}}
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Profile Picture</label>
                            @if($employee->profile_picture)
                                <div class="mb-2 d-flex align-items-center gap-2">
                                    <img src="{{ asset($employee->profile_picture) }}" class="rounded-circle border" style="width:56px;height:56px;object-fit:cover;">
                                    <small class="text-muted">Current picture</small>
                                </div>
                            @endif
                            <input type="file" name="profile_picture" class="form-control" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text small">Max 2MB. Leave blank to keep existing.</div>
                        </div>

                        {{-- Professional Info --}}
                        <div class="col-12 mt-3">
                            <h6 class="text-primary fw-bold border-bottom pb-2 mb-3">Professional Details</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Designation</label>
                            <select name="designation" class="form-select" required>
                                <option value="">-- Select Designation --</option>
                                @foreach($designations as $d)
                                    <option value="{{ $d->name }}" {{ old('designation', $employee->staff?->designation) == $d->name ? 'selected' : '' }}>
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Date of Joining</label>
                            <input type="date" name="joining_date" class="form-control"
                                value="{{ old('joining_date', $employee->staff?->joining_date?->format('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Assign School / Office</label>
                            <select name="school_id" class="form-select" required>
                                <option value="">-- Select School --</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}" {{ old('school_id', $employee->school_id) == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }} ({{ $school->udise_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 pt-3 border-top text-end mt-2">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-light px-4 me-2">Cancel</a>
                            <button type="submit" class="btn btn-dark px-5 fw-bold">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
