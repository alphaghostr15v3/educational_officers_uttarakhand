@extends('layouts.employee')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-muted">Education Ministerial Officers Association Uttarakhand Employee Portal</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-check text-primary fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Pending Leaves</h6>
                            <h2 class="mb-0">{{ $stats['pending_leaves'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('employee.leaves.index') }}" class="small text-primary text-decoration-none">Apply/View Leaves <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-exchange-alt text-warning fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Pending Transfers</h6>
                            <h2 class="mb-0">{{ $stats['pending_transfers'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('employee.transfers.index') }}" class="small text-warning text-decoration-none">Apply/View Transfers <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-bullhorn text-success fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Total Circulars</h6>
                            <h2 class="mb-0">{{ $stats['total_circulars'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('employee.circulars.index') }}" class="small text-success text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden bg-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 p-3 rounded">
                            <i class="fas fa-vote-yea text-danger fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Active Duties</h6>
                            <h2 class="mb-0">{{ $stats['active_duties'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#election-duty-section" class="small text-danger text-decoration-none">View Details <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Circulars -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Latest Official Circulars</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4">Title</th>
                                    <th>Date</th>
                                    <th class="text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_circulars as $circular)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-semibold">{{ $circular->title }}</div>
                                        <span class="small text-muted">ID: {{ $circular->circular_number }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($circular->circular_date)->format('d M, Y') }}</td>
                                    <td class="text-end px-4">
                                        <a href="{{ asset('uploads/circulars/' . $circular->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No recent circulars found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        @if($active_election_duties->count() > 0)
        <!-- Election Duty Information -->
        <div class="col-lg-8" id="election-duty-section">
            <div class="card border-0 shadow-sm border-start border-danger border-4 mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-danger"><i class="fas fa-vote-yea me-2"></i> Active Election Duty Information</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light text-danger">
                                <tr>
                                    <th class="px-4">Election & Role</th>
                                    <th>Location</th>
                                    <th>Period</th>
                                    <th class="text-end px-4">Order Ref</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($active_election_duties as $duty)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-bold">{{ $duty->election_name }}</div>
                                        <span class="badge bg-danger bg-opacity-10 text-danger small border border-danger border-opacity-25">{{ $duty->duty_type }}</span>
                                    </td>
                                    <td>{{ $duty->location ?? 'To be notified' }}</td>
                                    <td>
                                        <div class="small fw-semibold">{{ $duty->from_date->format('d M, Y') }}</div>
                                        @if($duty->to_date)
                                            <div class="small text-muted">to {{ $duty->to_date->format('d M, Y') }}</div>
                                        @endif
                                    </td>
                                    <td class="text-end px-4">
                                        <span class="badge bg-light text-dark border fw-normal">{{ $duty->order_number ?? 'N/A' }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($active_election_duties->first()->remarks)
                <div class="card-footer bg-white py-2 small border-0">
                    <i class="fas fa-info-circle text-muted me-1"></i> <strong>Note:</strong> {{ $active_election_duties->first()->remarks }}
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Service Book</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">View your complete service history, including postings and promotions.</p>
                    <a href="{{ route('employee.service-book') }}" class="btn btn-primary w-100">
                        <i class="fas fa-book me-2"></i> View Service Book
                    </a>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Request Correction</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">Notice an error in your data? Request a correction from the admin.</p>
                    <a href="{{ route('employee.service-book.correction') }}" class="btn btn-outline-danger w-100">
                        <i class="fas fa-edit me-2"></i> Request Correction
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
