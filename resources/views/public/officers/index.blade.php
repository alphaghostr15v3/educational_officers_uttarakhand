@extends('layouts.public')

@section('content')
<div class="bg-light py-4 border-bottom mb-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-0">Officer Directory</h2>
        <p class="text-muted mb-0">Search and find ministerial officers across Uttarakhand</p>
    </div>
</div>

<div class="container mb-5">
    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('officers') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">District</label>
                    <select name="district" class="form-select">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Designation</label>
                    <select name="designation" class="form-select">
                        <option value="">All Designations</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation }}" {{ request('designation') == $designation ? 'selected' : '' }}>{{ $designation }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Search Name</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Enter name or employee code..." value="{{ request('search') }}">
                        <button class="btn btn-primary px-4" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Officer Cards Grid -->
    <div class="row g-4">
        @php
            // Filtering logic (simplified for now as placeholder)
            $officers = \App\Models\Officer::query()
                ->when(request('district'), function($q) { $q->where('district_id', request('district')); })
                ->when(request('designation'), function($q) { $q->where('designation', request('designation')); })
                ->when(request('search'), function($q) { $q->where('name', 'like', '%'.request('search').'%')->orWhere('employee_code', 'like', '%'.request('search').'%'); })
                ->get();
        @endphp

        @if($officers->count() > 0)
            @foreach($officers as $officer)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0 transition-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                @if($officer->photo)
                                    <img src="{{ asset('uploads/officers/'.$officer->photo) }}" class="rounded-circle w-100 h-100" style="object-fit: cover;">
                                @else
                                    {{ strtoupper(substr($officer->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-primary">{{ $officer->name }}</h5>
                                <span class="badge bg-info-subtle text-info fw-bold">{{ $officer->designation }}</span>
                            </div>
                        </div>
                        <ul class="list-unstyled small mb-0">
                            <li class="mb-2"><i class="fas fa-map-marker-alt text-muted me-2"></i> <strong>District:</strong> {{ $officer->district->name }}</li>
                            <li class="mb-2"><i class="fas fa-id-badge text-muted me-2"></i> <strong>Employee ID:</strong> {{ $officer->employee_code }}</li>
                            <li class="mb-2"><i class="fas fa-id-card-clip text-muted me-2"></i> <strong>Cadre:</strong> Ministerial</li>
                            <li><i class="fas fa-calendar-check text-muted me-2"></i> <strong>Joined:</strong> {{ $officer->date_of_joining ? \Carbon\Carbon::parse($officer->date_of_joining)->format('M d, Y') : 'N/A' }}</li>
                        </ul>
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3">
                        <div class="d-grid ps-3 pe-3">
                            <a href="#" class="btn btn-outline-primary btn-sm fw-bold">View Full Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <i class="fas fa-user-slash fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No officers found matching your criteria</h4>
                <p>Try adjusting your filters or search terms.</p>
            </div>
        @endif
    </div>
</div>

<style>
.transition-hover:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
@endsection
