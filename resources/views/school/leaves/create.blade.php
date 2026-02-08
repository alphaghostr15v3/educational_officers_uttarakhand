@extends('layouts.school')

@section('title', 'Apply Leave')

@section('school_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Apply for Leave</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('school.leaves.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="type" class="form-label">Leave Type <span class="text-danger">*</span></label>
                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                    <option value="" selected disabled>Select Type</option>
                    <option value="CL">Casual Leave (CL)</option>
                    <option value="EL">Earned Leave (EL)</option>
                    <option value="Medical">Medical Leave</option>
                    <option value="Maternity">Maternity Leave</option>
                    <option value="Paternity">Paternity Leave</option>
                    <option value="Other">Other</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" required>
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" required>
                    @error('end_date')
                         <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required></textarea>
                 @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>
</div>
@endsection
