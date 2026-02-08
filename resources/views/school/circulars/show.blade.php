@extends('layouts.school')

@section('title', 'Circular: ' . $circular->title)

@section('school_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Circular Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('school.circulars.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Information</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <small class="text-muted d-block">Title</small>
                        <span class="fw-bold">{{ $circular->title }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Circular Number</small>
                        <span>{{ $circular->circular_number ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Date</small>
                        <span>{{ $circular->circular_date ? $circular->circular_date->format('d M Y') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <small class="text-muted d-block">Level</small>
                        <span class="badge bg-info text-dark">{{ ucfirst($circular->level) }}</span>
                    </li>
                </ul>
                <div class="mt-3 px-3">
                    <a href="{{ asset('uploads/circulars/' . $circular->file_path) }}" target="_blank" class="btn btn-success w-100">
                        <i class="fas fa-file-pdf me-2"></i> View Full Document
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Description</h5>
            </div>
            <div class="card-body">
                <p class="lead">{{ $circular->description ?? 'No additional description provided.' }}</p>
                
                <hr>
                
                <div class="mt-4">
                    <h6>Document Preview</h6>
                    <div class="ratio ratio-16x9">
                        <iframe src="{{ asset('uploads/circulars/' . $circular->file_path) }}" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
