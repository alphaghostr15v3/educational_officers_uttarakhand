@extends('layouts.public')

@section('content')
<div class="bg-dark text-white py-2 sticky-top" style="z-index: 1050; opacity: 0.9;">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <span class="badge bg-warning text-dark me-2">FRONTEND ADMIN</span>
            <span class="small fw-bold">Managing: @yield('admin_title', 'Site Content')</span>
        </div>
        <div class="d-flex gap-3">
            <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm"><i class="fas fa-eye me-1"></i> View Site</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-warning btn-sm"><i class="fas fa-columns me-1"></i> Backend Dashboard</a>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="list-group shadow-sm border-0">
                <a href="{{ route('admin.frontend.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.frontend.index') ? 'active bg-primary border-primary' : '' }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Content Overview
                </a>
                <a href="{{ route('admin.frontend.slider') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.frontend.slider*') ? 'active bg-primary border-primary' : '' }}">
                    <i class="fas fa-images me-2"></i> Hero Slider
                </a>
                <a href="{{ route('admin.portal-forms.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-th me-2"></i> Home Grid
                </a>
                <a href="{{ route('admin.news.index') }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-newspaper me-2"></i> News & Ticker
                </a>
            </div>
            
            <div class="card mt-4 border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-2">Helpful Tip</h6>
                    <p class="small text-muted mb-0">Changes made here are instantly reflected on the live website. Use high-resolution images for the best results.</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 min-vh-50">
                <div class="card-body p-4">
                    @yield('frontend_admin_content')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        border-color: #f8f9fa;
        font-weight: 500;
        color: #4a5568;
        padding: 0.75rem 1.25rem;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
    .list-group-item.active {
        box-shadow: 0 4px 6px -1px rgba(66, 153, 225, 0.4);
    }
</style>
@endsection
