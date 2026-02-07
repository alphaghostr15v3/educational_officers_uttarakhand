@extends('layouts.admin')

@section('page_title', 'Assign Election Duty')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">New Election Duty Assignment</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.election-duties.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select select2" required>
                                <option value="" disabled selected>Choose Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->email }}) - {{ $emp->district->name ?? 'Unknown Dist' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Election Name <span class="text-danger">*</span></label>
                            <input type="text" name="election_name" class="form-control" required placeholder="e.g. Lok Sabha 2024">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Duty Type <span class="text-danger">*</span></label>
                            <input type="text" name="duty_type" class="form-control" required placeholder="e.g. Polling Officer">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Location / Booth</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g. Booth #12, Govt School GIC">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Order Number</label>
                            <input type="text" name="order_number" class="form-control" placeholder="Govt Order Ref.">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">From Date <span class="text-danger">*</span></label>
                            <input type="date" name="from_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">To Date (Optional)</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                         <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                         <select name="status" class="form-select">
                             <option value="assigned">Assigned</option>
                             <option value="completed">Completed</option>
                             <option value="exempted">Exempted</option>
                         </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2" placeholder="Any special instructions..."></textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.election-duties.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Assign Duty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
