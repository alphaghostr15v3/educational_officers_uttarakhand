@extends('layouts.employee')

@section('content')
<style>
    :root {
        --uk-governance-blue: #003057;
        --uk-saffron: #FF9933;
        --uk-green: #138808;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--uk-governance-blue) 0%, #1a5c96 100%);
        border-radius: 1.5rem;
        padding: 3rem 2rem;
        color: white;
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 48, 87, 0.15);
    }

    .profile-header::after {
        content: "";
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        z-index: 1;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.2);
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        color: var(--uk-governance-blue);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
        font-size: 1.5rem;
    }

    .profile-avatar:hover .avatar-overlay {
        opacity: 1;
    }

    .nav-tabs-premium {
        border-bottom: 2px solid #eef0f2;
        gap: 2rem;
    }

    .nav-tabs-premium .nav-link {
        border: none;
        padding: 1rem 0;
        font-weight: 600;
        color: #6c757d;
        position: relative;
        transition: all 0.3s ease;
    }

    .nav-tabs-premium .nav-link.active {
        color: var(--uk-governance-blue);
        background: transparent;
    }

    .nav-tabs-premium .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 3px;
        background: var(--uk-governance-blue);
        border-radius: 3px;
    }

    .info-card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f8fafc;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .label-premium {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
        display: block;
        margin-bottom: 0.25rem;
    }

    .value-premium {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1e293b;
    }

    .form-control-premium {
        border: 2px solid #eef2f7;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-premium:focus {
        border-color: var(--uk-governance-blue);
        box-shadow: 0 0 0 4px rgba(0, 48, 87, 0.1);
        outline: none;
    }
</style>

<div class="container-fluid py-4">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                <div class="profile-avatar mx-auto" onclick="document.getElementById('profile_picture_input').click()">
                    @if($user->profile_picture)
                        <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->name }}" id="avatar_preview">
                    @else
                        <span id="avatar_initial">{{ substr($user->name, 0, 1) }}</span>
                        <img src="" alt="{{ $user->name }}" id="avatar_preview" style="display: none;">
                    @endif
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
            </div>
            <div class="col-md text-center text-md-start">
                <h1 class="fw-bold mb-1">{{ $user->name }}</h1>
                <p class="opacity-75 mb-2">
                    <i class="fas fa-id-badge me-2"></i> Employee Code: {{ $user->employee_code }} 
                    <span class="mx-2">|</span>
                    <i class="fas fa-calendar-alt me-2"></i> Member Since: {{ $user->created_at->format('M Y') }}
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-check-circle me-1 text-success"></i> Active Member
                    </span>
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm">
                        <i class="fas fa-shield-alt me-1 text-warning"></i> {{ $user->role == 'officer' ? 'Ministerial Officer' : ucfirst($user->role) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <ul class="nav nav-tabs nav-tabs-premium" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab">
                                <i class="fas fa-id-card me-2"></i>Professional Overview
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab">
                                <i class="fas fa-user-edit me-2"></i>Edit Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                                <i class="fas fa-shield-alt me-2"></i>Security
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-check-circle me-3 fs-4"></i>
                            <div>{{ session('success') }}</div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="tab-content" id="profileTabsContent">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">Current Designation</span>
                                        <div class="value-premium">{{ $user->staff?->designation ?? 'Not Assigned' }}</div>
                                        <i class="fas fa-user-tie mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">Current School / Office</span>
                                        <div class="value-premium">{{ $user->staff?->school?->name ?? ($user->school?->name ?? 'Not Linked') }}</div>
                                        <i class="fas fa-school mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">Date of Joining</span>
                                        <div class="value-premium">{{ $user->staff?->joining_date ? $user->staff->joining_date->format('d M, Y') : 'N/A' }}</div>
                                        <i class="fas fa-calendar-check mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">Division</span>
                                        <div class="value-premium">{{ $user->division->name ?? 'N/A' }}</div>
                                        <i class="fas fa-map-marked-alt mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">District</span>
                                        <div class="value-premium">{{ $user->district->name ?? 'N/A' }}</div>
                                        <i class="fas fa-city mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="info-card p-4 h-100">
                                        <span class="label-premium">Email Status</span>
                                        <div class="value-premium">Verified <i class="fas fa-check-circle text-success ms-1"></i></div>
                                        <i class="fas fa-envelope-open-text mt-3 opacity-25 float-end fs-1"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4 border-0 rounded-4 p-4">
                                <div class="d-flex">
                                    <i class="fas fa-info-circle fs-4 mt-1 me-3"></i>
                                    <div>
                                        <h6 class="fw-bold mb-1">Professional Data Management</h6>
                                        <p class="mb-0 small opacity-75">Your professional details like designation, school, and joining date are managed by the administrative department. If you find any discrepancies, please submit a correction request through the Service Book panel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Account Details Tab -->
                        <div class="tab-pane fade" id="account" role="tabpanel">
                            <form action="{{ route('employee.profile.update') }}" method="POST" class="row g-4" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label label-premium">Profile Picture</label>
                                    <input type="file" name="profile_picture" id="profile_picture_input" class="form-control form-control-premium @error('profile_picture') is-invalid @enderror" onchange="previewImage(this)">
                                    <small class="text-muted">Max size: 2MB (JPEG, PNG, JPG, GIF)</small>
                                    @error('profile_picture')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label label-premium">Full Name</label>
                                    <input type="text" name="name" class="form-control form-control-premium @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label label-premium">Mobile Number</label>
                                    <input type="text" name="mobile" class="form-control form-control-premium @error('mobile') is-invalid @enderror" value="{{ old('mobile', $user->mobile) }}" required>
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label label-premium text-muted">Email Address (Locked)</label>
                                    <input type="email" class="form-control form-control-premium bg-light" value="{{ $user->email }}" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label label-premium text-muted">Employee Code (Locked)</label>
                                    <input type="text" class="form-control form-control-premium bg-light" value="{{ $user->employee_code }}" disabled>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill shadow-sm fw-bold">
                                        <i class="fas fa-save me-2"></i> Update Account
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade" id="security" role="tabpanel">
                            <form action="{{ route('employee.profile.update') }}" method="POST" class="row g-4">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label label-premium">New Password</label>
                                    <input type="password" name="password" class="form-control form-control-premium @error('password') is-invalid @enderror" placeholder="Enter new password">
                                    <small class="text-muted">Min. 8 characters</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label label-premium">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-premium" placeholder="Repeat new password">
                                </div>
                                
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="mobile" value="{{ $user->mobile }}">

                                <div class="col-12">
                                    <div class="bg-light p-4 rounded-4 border-start border-4 border-warning">
                                        <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2 text-warning"></i>Important Note</h6>
                                        <p class="mb-0 small text-muted">Changing your password will require you to log in again with your new credentials. Please ensure you use a strong, unique password for better security.</p>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-warning px-5 py-2 rounded-pill shadow-sm fw-bold">
                                        <i class="fas fa-key me-2"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('avatar_preview');
                var initial = document.getElementById('avatar_initial');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (initial) {
                    initial.style.display = 'none';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
