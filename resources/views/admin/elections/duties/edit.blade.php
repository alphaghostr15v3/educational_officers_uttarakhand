@extends('layouts.admin')

@section('page_title', 'Edit Election Duty')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Edit Assignment Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.election-duties.update', $election_duty) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="" disabled>Choose Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ $election_duty->user_id == $emp->id ? 'selected' : '' }}>{{ $emp->name }} ({{ $emp->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Election Name <span class="text-danger">*</span></label>
                            <input type="text" name="election_name" class="form-control" required value="{{ $election_duty->election_name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Duty Type <span class="text-danger">*</span></label>
                            <input type="text" name="duty_type" class="form-control" required value="{{ $election_duty->duty_type }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Location / Booth</label>
                            <input type="text" name="location" class="form-control" value="{{ $election_duty->location }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Order Number</label>
                            <input type="text" name="order_number" class="form-control" value="{{ $election_duty->order_number }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="from_date" class="form-control" required value="{{ $election_duty->from_date->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">To Date (Optional)</label>
                            <input type="date" name="to_date" class="form-control" value="{{ $election_duty->to_date ? $election_duty->to_date->format('Y-m-d') : '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                         <select name="status" class="form-select">
                             <option value="assigned" {{ $election_duty->status === 'assigned' ? 'selected' : '' }}>Assigned</option>
                             <option value="completed" {{ $election_duty->status === 'completed' ? 'selected' : '' }}>Completed</option>
                             <option value="exempted" {{ $election_duty->status === 'exempted' ? 'selected' : '' }}>Exempted</option>
                         </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ $election_duty->remarks }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.election-duties.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
