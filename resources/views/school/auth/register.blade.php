@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0 overflow-hidden">
                <div class="row g-0">
                    <div class="col-12 bg-primary text-white p-4 text-center">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e0/Emblem_of_Uttarakhand.svg/1024px-Emblem_of_Uttarakhand.svg.png" 
                             alt="UK Emblem" style="height: 60px;" class="mb-3">
                        <h3 class="fw-bold mb-0">SCHOOL REGISTRATION</h3>
                        <p class="mb-0 opacity-75">UK Educational Ministerial Officers Portal</p>
                    </div>
                    
                    <div class="col-12 p-4 p-lg-5">
                        <form method="POST" action="{{ route('school.register') }}">
                            @csrf

                            <h5 class="border-bottom pb-2 mb-4 text-primary"><i class="fas fa-school me-2"></i>Institutional Details</h5>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">School Name (English)</label>
                                    <input type="text" name="school_name" class="form-control @error('school_name') is-invalid @enderror" value="{{ old('school_name') }}" required>
                                    @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">UDISE Code</label>
                                    <input type="text" name="udise_code" class="form-control @error('udise_code') is-invalid @enderror" value="{{ old('udise_code') }}" required placeholder="e.g. 05010100101">
                                    @error('udise_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">School Type</label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select Type</option>
                                        <option value="primary" {{ old('type') == 'primary' ? 'selected' : '' }}>Primary School</option>
                                        <option value="junior_high" {{ old('type') == 'junior_high' ? 'selected' : '' }}>Junior High School</option>
                                        <option value="secondary" {{ old('type') == 'secondary' ? 'selected' : '' }}>Secondary (High School)</option>
                                        <option value="senior_secondary" {{ old('type') == 'senior_secondary' ? 'selected' : '' }}>Senior Secondary (Inter College)</option>
                                        <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>Office / Other</option>
                                    </select>
                                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Division</label>
                                    <select name="division_id" id="division_id" class="form-select @error('division_id') is-invalid @enderror" required>
                                        <option value="">Select Division</option>
                                        @foreach($divisions as $division)
                                            <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('division_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">District</label>
                                    <select name="district_id" id="district_id" class="form-select @error('district_id') is-invalid @enderror" required>
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" data-division="{{ $district->division_id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('district_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Block</label>
                                    <input type="text" name="block" class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}" required>
                                    @error('block') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Phone Number</label>
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold">Full Address</label>
                                <textarea name="address" rows="2" class="form-control @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <h5 class="border-bottom pb-2 mb-4 text-primary mt-5"><i class="fas fa-key me-2"></i>Login Credentials</h5>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Account Holder Name (e.g. Principal/Clerk)</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Name of person managing this portal">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Email Address (Login Username)</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="School's official email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg fw-bold p-3 shadow-sm rounded-3">
                                    REGISTER SCHOOL <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0 text-muted">Already have a school account? <a href="{{ route('school.login') }}" class="fw-bold text-decoration-none">Login here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const districtOptions = Array.from(districtSelect.options);

    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;
        
        // Reset district select
        districtSelect.innerHTML = '<option value="">Select District</option>';
        
        if (divisionId) {
            const filteredOptions = districtOptions.filter(option => 
                option.getAttribute('data-division') === divisionId
            );
            filteredOptions.forEach(option => districtSelect.add(option));
        } else {
            // If no division selected, show all districts (or keep empty)
            districtOptions.forEach(option => districtSelect.add(option));
        }
    });
});
</script>
@endpush
@endsection
