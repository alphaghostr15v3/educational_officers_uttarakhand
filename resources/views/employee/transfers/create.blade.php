@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee.transfers.index') }}">My Transfers</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Application</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 fw-bold">Transfer Application</h1>
                    <p class="text-muted">Request a transfer to a different school or office.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-top border-success border-4">
                <div class="card-body p-4">
                    <form action="{{ route('employee.transfers.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="to_school_id" class="form-label fw-bold">Desired School / Office</label>
                            <select class="form-select select2 @error('to_school_id') is-invalid @enderror" id="to_school_id" name="to_school_id" required>
                                <option value="" selected disabled>Search and Select School...</option>
                                @foreach($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }} ({{ $school->district->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                            @error('to_school_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> You can only apply for schools with available vacancies.</div>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">Reason for Transfer Request</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="5" placeholder="Detailed reason for transfer (e.g., Mutual, Medical, Spouse Case, Distance)..." required minlength="15"></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success py-2">
                                <i class="fas fa-paper-plane me-2"></i> Submit Transfer Application
                            </button>
                            <a href="{{ route('employee.transfers.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
