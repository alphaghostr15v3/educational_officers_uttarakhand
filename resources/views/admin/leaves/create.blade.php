@extends('layouts.admin')

@section('page_title', 'Record Leave')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Leave Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.leaves.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="" disabled selected>Choose Employee</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Leave Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select" required>
                                <option value="Casual Leave (CL)">Casual Leave (CL)</option>
                                <option value="Earned Leave (EL)">Earned Leave (EL)</option>
                                <option value="Medical Leave">Medical Leave</option>
                                <option value="Maternity/Paternity">Maternity/Paternity</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Reason <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-4">
                         <label class="form-label fw-bold small text-uppercase text-muted">Initial Status</label>
                         <select name="status" class="form-select">
                             <option value="pending">Pending Approval</option>
                             <option value="approved">Approved</option>
                         </select>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.leaves.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Submit Leave Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
