@extends('layouts.admin')

@section('page_title', 'Add New School')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">School Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.schools.store') }}" method="POST">
                    @csrf
                    
                    @if(count($districts) > 0)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select District <span class="text-danger">*</span></label>
                            <select name="district_id" class="form-select" required>
                                <option value="" disabled selected>Choose District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required placeholder="e.g. Govt Inter College, Dehradun">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">UDISE Code</label>
                            <input type="text" name="udise_code" class="form-control" placeholder="11-digit code">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">School Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="secondary" selected>Secondary (High School)</option>
                                <option value="senior_secondary">Senior Secondary (Inter College)</option>
                                <option value="junior_high">Junior High School</option>
                                <option value="primary">Primary School</option>
                                <option value="office">Administrative Office</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Block <span class="text-danger">*</span></label>
                            <input type="text" name="block" class="form-control" required placeholder="e.g. Raipur">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Contact Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Office number">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Full address"></textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.schools.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Create School</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
