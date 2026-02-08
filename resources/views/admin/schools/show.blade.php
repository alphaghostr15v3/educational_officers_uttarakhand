@extends('layouts.admin')

@section('page_title', 'School Profile')

@section('admin_content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-school fa-4x text-primary shadow-sm p-3 bg-light rounded-circle"></i>
                </div>
                <h4 class="fw-bold mb-1">{{ $school->name }}</h4>
                <p class="text-primary fw-bold mb-3">{{ ucwords(str_replace('_', ' ', $school->type)) }}</p>
                <div class="badge bg-{{ $school->is_active ? 'success' : 'danger' }}-subtle text-{{ $school->is_active ? 'success' : 'danger' }} px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-{{ $school->is_active ? 'check-circle' : 'times-circle' }} me-1"></i> 
                    {{ $school->is_active ? 'Active' : 'Inactive' }}
                </div>
                <hr>
                <div class="text-start px-3">
                    <p class="mb-2 small"><strong><i class="fas fa-fingerprint me-2 text-muted"></i>UDISE:</strong> {{ $school->udise_code ?? 'N/A' }}</p>
                    <p class="mb-2 small"><strong><i class="fas fa-map-marker-alt me-2 text-muted"></i>Block:</strong> {{ $school->block }}</p>
                    <p class="mb-0 small"><strong><i class="fas fa-phone me-2 text-muted"></i>Phone:</strong> {{ $school->phone ?? 'N/A' }}</p>
                </div>
                <hr>
                <div class="px-3">
                    <h6 class="small fw-bold text-muted text-uppercase mb-3">Portal Login Account</h6>
                    @php
                        $schoolLogin = \App\Models\User::where('school_id', $school->id)->where('role', 'school')->first();
                    @endphp
                    
                    @if($schoolLogin)
                        <div class="alert alert-info py-2 px-3 small border-0 mb-3">
                            <i class="fas fa-user-circle me-1"></i> {{ $schoolLogin->email }}
                        </div>
                        <a href="{{ route('admin.schools.login.create', $school) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="fas fa-edit me-1"></i> Edit Login Account
                        </a>
                    @else
                        <div class="alert alert-warning py-2 px-3 small border-0 mb-3">
                            <i class="fas fa-exclamation-triangle me-1"></i> No login account created
                        </div>
                        <a href="{{ route('admin.schools.login.create', $school) }}" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-plus-circle me-1"></i> Create Login
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-success"><i class="fas fa-info-circle me-2"></i>Institutional Details</h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">District</label>
                        <div class="fw-bold">{{ $school->district->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Division</label>
                        <div class="fw-bold">{{ $school->division->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Email Address</label>
                        <div class="fw-bold">{{ $school->email ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Total Staff</label>
                        <div class="fw-bold">{{ $school->staffs->count() }} Members</div>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted d-block pb-1">Physical Address</label>
                        <div class="fw-bold">{{ $school->address ?? 'No address provided.' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-users me-2"></i>Staff Directory</h6>
                <a href="{{ route('admin.schools.index') }}" class="btn btn-sm btn-light">Back to List</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Name</th>
                                <th>Designation</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($school->staffs as $staff)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold small">{{ $staff->user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $staff->user->email }}</div>
                                </td>
                                <td class="small">{{ $staff->designation }}</td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-{{ $staff->current_status == 'active' ? 'success' : 'warning' }} small">
                                        {{ ucfirst($staff->current_status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small">No staff members assigned to this school.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
