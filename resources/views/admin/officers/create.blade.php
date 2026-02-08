@extends('layouts.admin')

@section('page_title', 'Add New Officer')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Officer Details</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.officers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Designation</label>
                            <select name="designation" class="form-select @error('designation') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->name }}" {{ old('designation') == $designation->name ? 'selected' : '' }}>
                                        {{ $designation->name }} ({{ ucfirst($designation->level) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Employee Code</label>
                            <input type="text" name="employee_code" class="form-control @error('employee_code') is-invalid @enderror" value="{{ old('employee_code') }}" required>
                            @error('employee_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile') }}">
                            @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Officer Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Division</label>
                            <select name="division_id" class="form-select @error('division_id') is-invalid @enderror" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ (auth()->user()->role !== 'state_admin' && auth()->user()->division_id == $division->id) || old('division_id') == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">District</label>
                            <select name="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ (auth()->user()->role === 'district_admin' && auth()->user()->district_id == $district->id) || old('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Save Officer</button>
                            <a href="{{ route('admin.officers.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
