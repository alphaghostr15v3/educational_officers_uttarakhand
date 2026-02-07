@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-0 fw-bold">My Service Book</h1>
            <p class="text-muted">Comprehensive history of your service in the department.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('employee.service-book.correction') }}" class="btn btn-outline-danger shadow-sm">
                <i class="fas fa-edit me-2"></i> Request Correction
            </a>
        </div>
    </div>

    <!-- Personal & Posting Info -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-id-card me-2"></i> Current Posting & Personal Details</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Employee Name</div>
                    <div class="fw-bold fs-5">{{ $user->name }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Employee Code</div>
                    <div class="fw-bold fs-5">{{ $user->employee_code ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Current Designation</div>
                    <div class="fw-bold fs-5 text-primary">{{ $user->staff->designation ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Current School/Office</div>
                    <div class="fw-bold fs-5">{{ $user->staff->school->name ?? 'Direct/District Office' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">District</div>
                    <div class="fw-bold">{{ $user->district->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Division</div>
                    <div class="fw-bold">{{ $user->division->name ?? 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Date of Joining</div>
                    <div class="fw-bold">{{ ($user->staff && $user->staff->joining_date) ? $user->staff->joining_date->format('d M, Y') : 'N/A' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="text-muted small text-uppercase fw-bold">Retirement Date</div>
                    <div class="fw-bold">{{ ($user->staff && $user->staff->retirement_date) ? $user->staff->retirement_date->format('d M, Y') : 'N/A' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer History -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-exchange-alt me-2"></i> Posting & Transfer History</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">From School/Office</th>
                            <th>To School/Office</th>
                            <th>Reason</th>
                            <th>Date</th>
                            <th class="px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                        <tr>
                            <td class="px-4">{{ $transfer->fromSchool->name ?? 'Initial Appointment' }}</td>
                            <td>{{ $transfer->toSchool->name ?? 'N/A' }}</td>
                            <td>{{ $transfer->reason }}</td>
                            <td>{{ $transfer->created_at->format('d M, Y') }}</td>
                            <td class="px-4">
                                <span class="badge rounded-pill bg-{{ $transfer->status == 'approved' ? 'success' : ($transfer->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($transfer->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No transfer history recorded.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Leave History -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i> Leave History</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">Leave Type</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th class="px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        @php
                            $start = \Carbon\Carbon::parse($leave->start_date);
                            $end = \Carbon\Carbon::parse($leave->end_date);
                            $days = $start->diffInDays($end) + 1;
                        @endphp
                        <tr>
                            <td class="px-4 fw-bold">{{ $leave->type }}</td>
                            <td>{{ $start->format('d M, Y') }}</td>
                            <td>{{ $end->format('d M, Y') }}</td>
                            <td>{{ $days }} Day(s)</td>
                            <td class="px-4">
                                <span class="badge rounded-pill bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No leave applications found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
