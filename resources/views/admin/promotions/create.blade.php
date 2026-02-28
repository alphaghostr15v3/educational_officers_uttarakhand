@extends('layouts.admin')

@section('page_title', 'Grant Promotion')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Promotion Order Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.promotions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="" disabled {{ !isset($selected_employee_id) ? 'selected' : '' }}>Choose Employee</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ (isset($selected_employee_id) && $selected_employee_id == $user->id) ? 'selected' : '' }}
                                        data-designation="{{ $user->designation }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Current Designation <span class="text-danger">*</span></label>
                            <input type="text" name="current_designation" id="current_designation" class="form-control" required placeholder="e.g. Junior Assistant" value="{{ isset($selected_employee_id) ? $users->find($selected_employee_id)->designation : '' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Promoted Designation <span class="text-danger">*</span></label>
                            <select name="promoted_designation" class="form-select" required>
                                <option value="" disabled selected>Select New Designation</option>
                                @foreach($designations as $des)
                                    <option value="{{ $des->name }}">{{ $des->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Promotion Date <span class="text-danger">*</span></label>
                            <input type="date" name="promotion_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Order Number</label>
                            <input type="text" name="order_number" class="form-control" placeholder="Govt Order No.">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Upload Order (PDF)</label>
                        <input type="file" name="file" class="form-control" accept=".pdf">
                    </div>

                    <div class="mb-4">
                         <label class="form-label fw-bold small text-uppercase text-muted">Status</label>
                         @if(auth()->user()->role === 'admin_panel')
                             <select name="status" class="form-select">
                                 <option value="pending">Pending Approval</option>
                                 <option value="district_forwarded">Forwarded to Division</option>
                                 <option value="division_recommended">Recommended to State</option>
                                 <option value="approved" selected>Approved & Finalized</option>
                             </select>
                         @else
                             <input type="text" class="form-control" value="Pending Approval" readonly>
                             <input type="hidden" name="status" value="pending">
                         @endif
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.promotions.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Grant Promotion</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.getElementById('user_id').addEventListener('change', function() {
        const designation = this.options[this.selectedIndex].getAttribute('data-designation');
        const currentDesignationInput = document.getElementById('current_designation');
        if (designation) {
            currentDesignationInput.value = designation;
        } else {
            currentDesignationInput.value = "";
        }
    });
</script>
@endpush
@endsection
