@extends('layouts.admin')

@section('page_title', 'Dashboard Overview')

@section('admin_content')
<div class="row g-4 mb-4">
    <!-- Stat Cards -->
    <div class="col-md-3">
        <div class="card stat-card shadow-sm h-100 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Officers</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($stats['officers_count']) }}</h3>
                </div>
                <div class="icon-box bg-primary-subtle text-primary">
                    <i class="fas fa-users fa-lg"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-success"><i class="fas fa-arrow-up me-1"></i> Active</span>
                <span class="text-muted ms-2">Registered staff</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card stat-card shadow-sm h-100 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Orders & Circles</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($stats['orders_count']) }}</h3>
                </div>
                <div class="icon-box bg-success-subtle text-success">
                    <i class="fas fa-file-invoice fa-lg"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-muted">Total documents found</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card shadow-sm h-100 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Donation Welfare</h6>
                    <h3 class="fw-bold mb-0">₹ {{ number_format($stats['donations_total']) }}</h3>
                </div>
                <div class="icon-box bg-warning-subtle text-warning">
                    <i class="fas fa-hand-holding-heart fa-lg"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-muted text-truncate d-block">Total collected funds</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card shadow-sm h-100 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Active Elections</h6>
                    <h3 class="fw-bold mb-0">{{ number_format($stats['active_elections']) }}</h3>
                </div>
                <div class="icon-box bg-danger-subtle text-danger">
                    <i class="fas fa-vote-yea fa-lg"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-danger fw-bold">Live Portal</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Actions -->
    <div class="col-md-8">
        <div class="card table-card p-4">
            <h5 class="fw-bold mb-4">Quick Management Actions</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="#" class="btn btn-light w-100 h-100 py-4 border">
                        <i class="fas fa-plus-circle fa-2x text-primary mb-2"></i>
                        <div class="fw-bold small">Add New Officer</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-light w-100 h-100 py-4 border">
                        <i class="fas fa-cloud-upload-alt fa-2x text-success mb-2"></i>
                        <div class="fw-bold small">Upload Govt Order</div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-light w-100 h-100 py-4 border">
                        <i class="fas fa-id-card fa-2x text-warning mb-2"></i>
                        <div class="fw-bold small">Manage ID Cards</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Placeholder -->
    <div class="col-md-4">
        <div class="card table-card p-4">
            <h5 class="fw-bold mb-4">Recent Activity Logs</h5>
            <div class="list-group list-group-flush small">
                <div class="list-group-item px-0 border-0 mb-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <span class="badge bg-primary-subtle text-primary">State Admin</span>
                        <small class="text-muted">2 mins ago</small>
                    </div>
                    <p class="mb-0 fw-bold">Login successful</p>
                    <small class="text-muted">User: admin@uk.gov.in</small>
                </div>
                <div class="list-group-item px-0 border-0 mb-3">
                    <div class="d-flex w-100 justify-content-between mb-1">
                        <span class="badge bg-success-subtle text-success">Migration</span>
                        <small class="text-muted">1 hour ago</small>
                    </div>
                    <p class="mb-0 fw-bold">Seeded 13 districts</p>
                    <small class="text-muted">Source: DatabaseSeeder</small>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-link btn-sm text-decoration-none fw-bold">View Audit Trail</a>
            </div>
        </div>
    </div>
</div>
@endsection
