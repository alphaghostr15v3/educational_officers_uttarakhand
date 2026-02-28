@extends('state-admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-1 fw-bold">State Administration Portal</h2>
                        <p class="mb-0 opacity-75">Overview of Uttarkhand Educational Ministerial Officers</p>
                    </div>
                    <div>
                        <i class="fas fa-chess-king fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            <div class="card shadow-sm border-0 border-start border-success border-4 h-100">
                <div class="card-body">
                    <h6 class="text-muted fw-bold text-uppercase mb-2">Active Officers</h6>
                    <h2 class="mb-0 fw-bold text-dark">--</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
