@extends('layouts.school')

@section('title', 'Apply Transfer')

@section('school_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Apply for Transfer</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('school.transfers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="to_school_id" class="form-label">Transfer To (Destination School) <span class="text-danger">*</span></label>
                <select class="form-select @error('to_school_id') is-invalid @enderror" id="to_school_id" name="to_school_id" required>
                    <option value="" selected disabled>Select School</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }} ({{ $school->block }})</option>
                    @endforeach
                </select>
                @error('to_school_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Currently showing all active schools.</div>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Transfer <span class="text-danger">*</span></label>
                <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" required minlength="10" placeholder="Please provide detailed reason..."></textarea>
                @error('reason')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>
</div>
@endsection
