@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee.leaves.index') }}">My Leaves</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Application</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 fw-bold">Leave Application</h1>
                    <p class="text-muted">Fill in the details to apply for a leave.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('employee.leaves.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="type" class="form-label fw-bold">Leave Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="" selected disabled>Select Type...</option>
                                <option value="Casual Leave">Casual Leave (CL)</option>
                                <option value="Earned Leave">Earned Leave (EL)</option>
                                <option value="Medical Leave">Medical Leave (ML)</option>
                                <option value="Maternity Leave">Maternity Leave</option>
                                <option value="Commuted Leave">Commuted Leave</option>
                                <option value="Special Leave">Special Leave</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">Reason for Leave</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" placeholder="Briefly explain the reason for your leave request..." required minlength="10"></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2">
                                <i class="fas fa-paper-plane me-2"></i> Submit Application
                            </button>
                            <a href="{{ route('employee.leaves.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
