@extends('layouts.admin')

@section('page_title', 'Add Birthday Entry')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-primary">Add New Birthday Entry</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.birthdays.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Employee Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter full name">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Designation <span class="text-danger">*</span></label>
                            <select name="designation" class="form-select @error('designation') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->name }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required>
                            @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Recommended: Square format, Max 2MB</small>
                            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 mb-4">
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <label class="form-check-label fw-bold" for="is_active">Active Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save me-1"></i> Save Birthday Entry
                        </button>
                        <a href="{{ route('admin.birthdays.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
