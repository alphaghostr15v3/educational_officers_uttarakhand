@extends('layouts.admin')

@section('page_title', 'Add New Contribution')

@section('admin_content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <!-- Modern Form Card -->
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 d-flex align-items-center" style="background: #6f42c1; color: white;">
                    <i class="fas fa-plus-circle me-2"></i>
                    <h6 class="mb-0 fw-bold">Add New Anshandan Receipt</h6>
                </div>
                <div class="card-body p-4 bg-light-subtle">
                    <form action="{{ route('admin.anshandan.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Member Info Section -->
                            <div class="col-12 py-2 border-bottom mb-3">
                                <h6 class="text-primary mb-0"><i class="fas fa-user-circle me-2"></i>Member Information</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Select Existing Member (Optional)</label>
                                <select name="user_id" id="user_id" class="form-select border-0 shadow-sm" style="border-radius: 8px;">
                                    <option value="">-- Choose Member --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" data-name="{{ $member->name }}">{{ $member->name }} ({{ $member->employee_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Member Name <span class="text-danger">*</span></label>
                                <input type="text" name="member_name" id="member_name" class="form-control border-0 shadow-sm" placeholder="Enter Full Name" required value="{{ old('member_name') }}" style="border-radius: 8px;">
                            </div>

                            <!-- Financial Section -->
                            <div class="col-12 py-2 border-bottom mb-3 mt-4">
                                <h6 class="text-primary mb-0"><i class="fas fa-money-bill-wave me-2"></i>Contribution Details</h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <span class="input-group-text bg-white border-0 text-muted">₹</span>
                                    <input type="number" name="amount" class="form-control border-0" step="0.01" placeholder="0.00" required value="{{ old('amount') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Receipt Number <span class="text-danger">*</span></label>
                                <input type="text" name="receipt_no" class="form-control border-0 shadow-sm" placeholder="RECEIPT-001" required value="{{ old('receipt_no') }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control border-0 shadow-sm" required value="{{ old('payment_date', date('Y-m-d')) }}" style="border-radius: 8px;">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-select border-0 shadow-sm" required style="border-radius: 8px;">
                                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                        <option value="{{ $m }}" {{ (old('month', date('F')) == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control border-0 shadow-sm" required value="{{ old('year', date('Y')) }}" min="2020" max="{{ date('Y')+1 }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select border-0 shadow-sm" required style="border-radius: 8px;">
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online Transfer</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="form-label small fw-bold text-muted">Upload Attachment (Scanned Receipt)</label>
                                <div class="file-upload-wrapper border border-dashed border-2 p-4 text-center" style="border-radius: 12px; background: #fafafa; border-color: #dee2e6 !important;">
                                    <i class="fas fa-cloud-upload-alt text-muted fa-2x mb-2"></i>
                                    <input type="file" name="receipt_file" class="form-control d-none" id="receipt_file" accept=".jpg,.jpeg,.png,.pdf">
                                    <label for="receipt_file" class="d-block mb-1 text-primary cursor-pointer" style="cursor: pointer;">Browse or Drag File</label>
                                    <div class="small text-muted" id="file_name_display">No file selected (JPG, PNG, PDF | Max 2MB)</div>
                                </div>
                            </div>

                            <!-- Jurisdiction info for Admin -->
                            @if(auth()->user()->role === 'admin_panel' || auth()->user()->role === 'state_admin')
                            <div class="col-12 py-2 border-bottom mb-3 mt-4">
                                <h6 class="text-primary mb-0"><i class="fas fa-map-marker-alt me-2"></i>Local Jurisdiction</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">District <span class="text-danger">*</span></label>
                                <select name="district_id" class="form-select border-0 shadow-sm" required style="border-radius: 8px;">
                                    <option value="">Choose District</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Block (Optional)</label>
                                <select name="block_id" class="form-select border-0 shadow-sm" style="border-radius: 8px;">
                                    <option value="">All Blocks</option>
                                    @foreach($blocks as $block)
                                        <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @elseif(auth()->user()->role === 'district_admin')
                                <input type="hidden" name="district_id" value="{{ auth()->user()->district_id }}">
                                <div class="col-md-12 mt-4">
                                    <label class="form-label small fw-bold text-muted">Block (Optional)</label>
                                    <select name="block_id" class="form-select border-0 shadow-sm" style="border-radius: 8px;">
                                        <option value="">Current District Scale</option>
                                        @foreach($blocks as $block)
                                            <option value="{{ $block->id }}" {{ old('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <input type="hidden" name="district_id" value="{{ auth()->user()->district_id }}">
                                <input type="hidden" name="block_id" value="{{ auth()->user()->block_id }}">
                            @endif

                            <div class="col-12 mt-4">
                                <label class="form-label small fw-bold text-muted">Remarks / Notes</label>
                                <textarea name="remarks" class="form-control border-0 shadow-sm" rows="3" placeholder="Add any details here..." style="border-radius: 12px;">{{ old('remarks') }}</textarea>
                            </div>

                            <div class="col-12 mt-5 text-center">
                                <hr class="my-4">
                                <a href="{{ route('admin.anshandan.index') }}" class="btn btn-light px-5 py-2 me-2" style="border-radius: 10px;">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #a29bfe 100%); border: 0; border-radius: 10px; min-width: 200px;">Save Contribution</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.15);
    }
    .input-group-text {
        font-weight: bold;
    }
    label span.text-danger { font-size: 1.1rem; }
    .cursor-pointer { cursor: pointer; }
    .file-upload-wrapper:hover {
        background: #f1f1f1 !important;
        border-color: #6f42c1 !important;
    }
</style>

@push('scripts')
<script>
    // Autofill name from member selection
    document.getElementById('user_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('member_name').value = selectedOption.dataset.name;
        }
    });

    // File display name update
    document.getElementById('receipt_file').addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            document.getElementById('file_name_display').innerText = 'Selected: ' + this.files[0].name;
            document.getElementById('file_name_display').classList.add('text-primary');
        }
    });
</script>
@endpush

@endsection
