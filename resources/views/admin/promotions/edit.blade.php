@extends('layouts.admin')

@section('page_title', 'Edit Promotion')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Edit Promotion Order Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.promotions.update', $promotion) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="" disabled>Choose Employee</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $promotion->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Current Designation <span class="text-danger">*</span></label>
                            <input type="text" name="current_designation" class="form-control" required value="{{ $promotion->current_designation }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Promoted Designation <span class="text-danger">*</span></label>
                            <input type="text" name="promoted_designation" class="form-control" required value="{{ $promotion->promoted_designation }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Promotion Date <span class="text-danger">*</span></label>
                            <input type="date" name="promotion_date" class="form-control" required value="{{ $promotion->promotion_date->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Order Number</label>
                            <input type="text" name="order_number" class="form-control" value="{{ $promotion->order_number }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Upload Order (PDF) - Leave blank to keep current</label>
                        <input type="file" name="file" class="form-control" accept=".pdf">
                        @if($promotion->file_path)
                            <div class="mt-2 small">
                                <i class="fas fa-file-pdf text-danger"></i> <a href="{{ asset('uploads/promotions/'.$promotion->file_path) }}" target="_blank">Current Order File</a>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                         <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                         @php $role = auth()->user()->role; @endphp
                         @if($role === 'state_admin')
                             <select name="status" class="form-select">
                                 <option value="pending" {{ $promotion->status === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                                 <option value="district_forwarded" {{ $promotion->status === 'district_forwarded' ? 'selected' : '' }}>Forwarded to Division</option>
                                 <option value="division_recommended" {{ $promotion->status === 'division_recommended' ? 'selected' : '' }}>Recommended to State</option>
                                 <option value="approved" {{ $promotion->status === 'approved' ? 'selected' : '' }}>Approved & Finalized</option>
                                 <option value="rejected" {{ $promotion->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                             </select>
                         @else
                             <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $promotion->status)) }}" readonly>
                             <input type="hidden" name="status" value="{{ $promotion->status }}">
                         @endif
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Promotion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
