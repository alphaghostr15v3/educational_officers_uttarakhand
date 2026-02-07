@extends('layouts.employee')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2 class="mb-4">My Profile</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center pt-5">
                <div class="mb-3">
                    <div class="avatar-circle mx-auto bg-primary text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem; border-radius: 50%;">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
                <h4 class="fw-bold">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->role == 'officer' ? 'Ministerial Officer' : ucfirst($user->role) }}</p>
                <div class="badge bg-success mb-3">Active Member</div>
            </div>
            <div class="card-footer bg-light p-3">
                <div class="d-flex justify-content-between text-muted small">
                    <span>Joined</span>
                    <span class="fw-bold">{{ $user->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Profile Details</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                 @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employee.profile.update') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Email Address</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            <small class="text-muted">Email cannot be changed</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Employee Code</label>
                            <input type="text" class="form-control" value="{{ $user->employee_code }}" disabled>
                            <small class="text-muted">Contact admin to update code</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Division</label>
                            <input type="text" class="form-control" value="{{ $user->division->name ?? 'N/A' }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">District</label>
                            <input type="text" class="form-control" value="{{ $user->district->name ?? 'N/A' }}" disabled>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="fw-bold mb-3">Change Password</h6>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted text-uppercase fw-bold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
