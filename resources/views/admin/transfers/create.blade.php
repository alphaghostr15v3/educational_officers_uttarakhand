@extends('layouts.admin')

@section('page_title', 'Initiate Transfer')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Transfer Details</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.transfers.store') }}" method="POST">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Select Employee <span class="text-danger">*</span></label>
                            <select name="user_id" id="employee_select" class="form-select" required>
                                <option value="" disabled selected>Choose Employee</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" data-school-id="{{ $user->staff->school_id ?? '' }}">
                                        {{ $user->name }} ({{ $user->email }}) 
                                        @if(isset($user->staff->school))
                                            - {{ $user->staff->school->name }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Current Office <span class="text-danger">*</span></label>
                            <select name="from_school_id" id="from_office_select" class="form-select" required>
                                <option value="" disabled selected>Select Current Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Transferred To <span class="text-danger">*</span></label>
                            <select name="to_school_id" class="form-select" required>
                                <option value="" disabled selected>Select Target Office</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Reason / Order Details <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Reason for transfer or Gov Order No."></textarea>
                    </div>

                    <div class="mb-4">
                         <label class="form-label fw-bold small text-uppercase text-muted">Initial Status</label>
                         <select name="status" class="form-select">
                             <option value="pending">Pending Approval (Start Workflow)</option>
                             <option value="approved">Approved (Issue Immediately)</option>
                         </select>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.transfers.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Initiate Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('employee_select').addEventListener('change', function() {
        const schoolId = this.options[this.selectedIndex].getAttribute('data-school-id');
        const fromOfficeSelect = document.getElementById('from_office_select');
        
        if (schoolId) {
            fromOfficeSelect.value = schoolId;
        } else {
            fromOfficeSelect.value = "";
        }
    });
</script>
@endpush
@endsection
