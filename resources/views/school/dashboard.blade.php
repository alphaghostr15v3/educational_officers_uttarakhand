@extends('layouts.school')

@section('page_title', 'Dashboard')

@section('school_content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75">Total Staff</h6>
                        <h2 class="my-2 display-6 fw-bold">{{ $staffCount ?? 0 }}</h2>
                        <small class="opacity-75">Active Records</small>
                    </div>
                    <i class="fas fa-chalkboard-teacher fa-2x opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <a href="{{ route('school.staff.index') }}" class="text-white text-decoration-none small">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75">Student Strength</h6>
                        <h2 class="my-2 display-6 fw-bold">{{ $school->studentStrengths()->sum('total') ?? 0 }}</h2>
                        <small class="opacity-75">Current Enrollment</small>
                    </div>
                    <i class="fas fa-user-graduate fa-2x opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <a href="{{ route('school.students.index') }}" class="text-white text-decoration-none small">Update Detail <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-dark h-100 shadow-sm border-0">
             <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75">Pending Transfers</h6>
                        <h2 class="my-2 display-6 fw-bold">{{ $pendingTransfers ?? 0 }}</h2>
                        <small>Awaiting Approval</small>
                    </div>
                    <i class="fas fa-exchange-alt fa-2x opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-black bg-opacity-10 border-0">
                <a href="{{ route('school.transfers.create') }}" class="text-dark text-decoration-none small">Apply New <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-4">
        <div class="card bg-danger text-white h-100 shadow-sm border-0">
             <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-0 opacity-75">Pending Leaves</h6>
                        <h2 class="my-2 display-6 fw-bold">{{ $pendingLeaves ?? 0 }}</h2>
                        <small>Awaiting Status</small>
                    </div>
                    <i class="fas fa-calendar-check fa-2x opacity-25"></i>
                </div>
            </div>
            <div class="card-footer bg-white bg-opacity-10 border-0">
                <a href="{{ route('school.leaves.create') }}" class="text-white text-decoration-none small">Apply Leave <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-white py-3 border-0">
                 <h6 class="mb-0 fw-bold"><i class="fas fa-bolt text-primary me-2"></i> Quick Actions</h6>
            </div>
            <div class="card-body pt-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('school.staff.create') }}" class="list-group-item list-group-item-action py-3 border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="fas fa-user-plus text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Add New Staff</div>
                                <div class="small text-muted">Register member at school</div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('school.documents.index') }}" class="list-group-item list-group-item-action py-3 border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="fas fa-file-upload text-success"></i>
                            </div>
                            <div>
                                <div class="fw-bold">Upload Documents</div>
                                <div class="small text-muted">Upload orders or letters</div>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('school.infrastructure.index') }}" class="list-group-item list-group-item-action py-3 border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-light p-2 rounded me-3">
                                <i class="fas fa-building text-info"></i>
                            </div>
                            <div>
                                <div class="fw-bold">School Facilities</div>
                                <div class="small text-muted">Update infrastructure data</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-0">
             <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                 <h6 class="mb-0 fw-bold"><i class="fas fa-bullhorn text-danger me-2"></i> Latest Circulars</h6>
                 <a href="{{ route('school.circulars.index') }}" class="small text-decoration-none">View All</a>
            </div>
            <div class="card-body pt-0">
                <div class="list-group list-group-flush">
                    @forelse($latestCirculars as $circular)
                        <a href="{{ route('school.circulars.show', $circular->id) }}" class="list-group-item list-group-item-action border-0 px-0">
                            <div class="fw-bold">{{ Str::limit($circular->title, 40) }}</div>
                            <div class="small text-muted">{{ $circular->circular_date->format('d M Y') }}</div>
                        </a>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle mb-2"></i><br>No recent circulars.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100 border-0">
             <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                 <h6 class="mb-0 fw-bold"><i class="fas fa-folder-open text-warning me-2"></i> Recent Documents</h6>
                 <a href="{{ route('school.documents.index') }}" class="small text-decoration-none">View All</a>
            </div>
            <div class="card-body pt-0">
                <div class="list-group list-group-flush">
                    @forelse($recentDocuments as $doc)
                        <a href="{{ asset('uploads/school_documents/' . $doc->file_path) }}" target="_blank" class="list-group-item list-group-item-action border-0 px-0">
                            <div class="fw-bold">{{ Str::limit($doc->title, 40) }}</div>
                            <div class="small text-muted">{{ $doc->created_at->format('d M Y') }}</div>
                        </a>
                    @empty
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-info-circle mb-2"></i><br>No documents uploaded.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
