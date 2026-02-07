@extends('layouts.admin')

@section('page_title', 'Staff Member Profile')

@section('admin_content')
<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center py-5">
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($staff->user->name) }}&size=128&background=random" class="rounded-circle shadow-sm" alt="Profile Image">
                </div>
                <h4 class="fw-bold mb-1">{{ $staff->user->name }}</h4>
                <p class="text-primary fw-bold mb-3">{{ $staff->designation }}</p>
                <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3">
                    <i class="fas fa-check-circle me-1"></i> {{ ucfirst($staff->current_status) }}
                </div>
                <hr>
                <div class="text-start px-3">
                    <p class="mb-2 small"><strong><i class="fas fa-envelope me-2 text-muted"></i>Email:</strong> {{ $staff->user->email }}</p>
                    <p class="mb-0 small"><strong><i class="fas fa-phone me-2 text-muted"></i>Mobile:</strong> {{ $staff->user->mobile ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h6 class="fw-bold mb-0 text-success"><i class="fas fa-info-circle me-2"></i>Employment Details</h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Current Posting</label>
                        <div class="fw-bold">{{ $staff->school->name }}</div>
                        <div class="small text-muted">{{ $staff->school->district->name }}, {{ $staff->school->division->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Joining Date</label>
                        <div class="fw-bold">{{ $staff->joining_date ? $staff->joining_date->format('d M, Y') : 'N/A' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Employee ID</label>
                        <div class="fw-bold">#{{ str_pad($staff->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted d-block pb-1">Role Type</label>
                        <div class="fw-bold">{{ ucfirst($staff->user->role) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-history me-2"></i>Recent Activity</h6>
                <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-light">Back to List</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Activity</th>
                                <th>Date</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4 small">Staff account created</td>
                                <td class="small">{{ $staff->created_at->format('d M, Y') }}</td>
                                <td class="text-end pe-4"><span class="badge bg-success small">Logged</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
