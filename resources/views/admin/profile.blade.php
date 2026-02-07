@extends('layouts.admin')

@section('page_title', 'My Profile')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Profile Details</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                    <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=1e3a8a&color=fff&size=128" class="rounded-circle me-4 shadow-sm" style="width: 80px; height: 80px;">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <span class="badge {{ $user->role == 'state_admin' ? 'badge-state' : ($user->role === 'division_admin' ? 'badge-division' : 'badge-district') }} px-3 py-2">
                            {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Email Address</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <small class="text-muted">Email cannot be changed.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label fw-bold small text-muted">Full Name</label>
                         <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    @if($user->division)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">Division</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->division->name }}" readonly>
                    </div>
                    @endif

                    @if($user->district)
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted">District</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->district->name }}" readonly>
                    </div>
                    @endif

                    <hr class="my-4">
                    <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-lock me-2"></i>Change Password</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
