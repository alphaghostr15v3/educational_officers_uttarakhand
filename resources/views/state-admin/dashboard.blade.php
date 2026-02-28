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
