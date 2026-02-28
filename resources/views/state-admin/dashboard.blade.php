@extends('layouts.admin')

@section('page_title', 'State Administration Portal')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <!-- Quick Stats placeholder -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 border-start border-primary border-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold text-uppercase mb-2">Total Districts</h6>
                    <h2 class="mb-0 fw-bold text-dark">13</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0 border-start border-warning border-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold text-uppercase mb-2">Pending Help Requests</h6>
                    <h2 class="mb-0 fw-bold text-dark">{{ $stats['pending_help'] }}</h2>
                </div>
                <div class="card-footer bg-white border-0 py-2">
                    <a href="{{ route('admin.help-requests.index') }}" class="small text-warning text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
