@extends('layouts.admin')

@section('page_title', isset($school) ? 'Edit School' : 'Add New School')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">{{ isset($school) ? 'Update School Details' : 'School Details' }}</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ isset($school) ? route('admin.schools.update', $school) : route('admin.schools.store') }}" method="POST">
                    @csrf
                    @if(isset($school)) @method('PUT') @endif
                    
                    @if(count($districts) > 0)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select District <span class="text-danger">*</span></label>
                            <select name="district_id" class="form-select" required>
                                <option value="" disabled {{ !isset($school) ? 'selected' : '' }}>Choose District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id', isset($school) ? $school->district_id : '') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $school->name ?? '') }}" required placeholder="e.g. Govt Inter College, Dehradun">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">UDISE Code</label>
                            <input type="text" name="udise_code" class="form-control" value="{{ old('udise_code', $school->udise_code ?? '') }}" placeholder="11-digit code">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">School Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="primary" {{ old('type', $school->type ?? '') == 'primary' ? 'selected' : '' }}>Primary School</option>
                                <option value="junior_high" {{ old('type', $school->type ?? '') == 'junior_high' ? 'selected' : '' }}>Junior High School</option>
                                <option value="secondary" {{ old('type', $school->type ?? '') == 'secondary' ? 'selected' : '' }}>Secondary (High School)</option>
                                <option value="senior_secondary" {{ old('type', $school->type ?? 'secondary') == 'senior_secondary' ? 'selected' : '' }}>Senior Secondary (Inter College)</option>
                                <option value="office" {{ old('type', $school->type ?? '') == 'office' ? 'selected' : '' }}>Administrative Office</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Block <span class="text-danger">*</span></label>
                            <input type="text" name="block" class="form-control" value="{{ old('block', $school->block ?? '') }}" required placeholder="e.g. Raipur">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Contact Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $school->phone ?? '') }}" placeholder="Office number">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $school->email ?? '') }}" placeholder="official@email.com">
                        </div>
                        @if(isset($school))
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Status <span class="text-danger">*</span></label>
                            <select name="is_active" class="form-select" required>
                                <option value="1" {{ old('is_active', $school->is_active) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !old('is_active', $school->is_active) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Full address">{{ old('address', $school->address ?? '') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.schools.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">{{ isset($school) ? 'Update School' : 'Create School' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
