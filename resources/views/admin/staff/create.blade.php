@extends('layouts.admin')

@section('page_title', 'Add New Staff')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Staff Service Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.staff.store') }}" method="POST">
                    @csrf
                    
                    <h6 class="fw-bold mb-3 text-primary">Personal Information</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="Employee Name">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required placeholder="Official Email">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile" class="form-control" required placeholder="10-digit number">
                        </div>
                    </div>

                    <h6 class="fw-bold mb-3 text-primary">Service Details</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">School/Office <span class="text-danger">*</span></label>
                            <select name="school_id" class="form-select" required>
                                <option value="" disabled selected>Select School</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Designation <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control" required placeholder="e.g. Assistant Teacher">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Date of Joining <span class="text-danger">*</span></label>
                            <input type="date" name="joining_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle me-1"></i> A user account will be automatically created with default password <strong>password123</strong>.
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Create Staff Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
