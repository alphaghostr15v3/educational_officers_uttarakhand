@extends('layouts.admin')

@section('page_title', 'Edit Contribution')

@section('admin_content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <!-- Modern Form Card -->
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #6f42c1; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h6 class="mb-0 fw-bold">Edit Anshandan Receipt: {{ $anshandan->receipt_no }}</h6>
                    </div>
                    <a href="{{ route('admin.anshandan.index') }}" class="btn btn-sm btn-light border-0 px-3" style="border-radius: 8px;">Back to List</a>
                </div>
                <div class="card-body p-4 bg-light-subtle">
                    <form action="{{ route('admin.anshandan.update', $anshandan->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Member Info Section -->
                            <div class="col-12 py-2 border-bottom mb-3">
                                <h6 class="text-primary mb-0"><i class="fas fa-user-circle me-2"></i>Member Information</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Select Member (Optional)</label>
                                <select name="user_id" id="user_id" class="form-select border-0 shadow-sm" style="border-radius: 8px;">
                                    <option value="">-- Choose Member --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" data-name="{{ $member->name }}" {{ $anshandan->user_id == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->employee_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Member Name <span class="text-danger">*</span></label>
                                <input type="text" name="member_name" id="member_name" class="form-control border-0 shadow-sm" required value="{{ old('member_name', $anshandan->member_name) }}" style="border-radius: 8px;">
                            </div>

                            <!-- Financial Section -->
                            <div class="col-12 py-2 border-bottom mb-3 mt-4">
                                <h6 class="text-primary mb-0"><i class="fas fa-money-bill-wave me-2"></i>Contribution Details</h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                    <span class="input-group-text bg-white border-0 text-primary fw-bold">₹</span>
                                    <input type="number" name="amount" class="form-control border-0" step="0.01" required value="{{ old('amount', $anshandan->amount) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Receipt Number <span class="text-danger">*</span></label>
                                <input type="text" name="receipt_no" class="form-control border-0 shadow-sm" required value="{{ old('receipt_no', $anshandan->receipt_no) }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control border-0 shadow-sm" required value="{{ old('payment_date', $anshandan->payment_date) }}" style="border-radius: 8px;">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-select border-0 shadow-sm" required style="border-radius: 8px;">
                                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                        <option value="{{ $m }}" {{ (old('month', $anshandan->month) == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control border-0 shadow-sm" required value="{{ old('year', $anshandan->year) }}" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select border-0 shadow-sm" required style="border-radius: 8px;">
                                    <option value="Cash" {{ $anshandan->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Online" {{ $anshandan->payment_method == 'Online' ? 'selected' : '' }}>Online Transfer</option>
                                    <option value="Cheque" {{ $anshandan->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="form-label small fw-bold text-muted">Update Attachment</label>
                                <div class="file-upload-wrapper border border-dashed border-2 p-3 text-center mb-2" style="border-radius: 12px; background: #fafafa; border-color: #dee2e6 !important;">
                                    <i class="fas fa-file-upload text-muted fa-lg mb-2"></i>
                                    <input type="file" name="receipt_file" class="form-control d-none" id="receipt_file" accept=".jpg,.jpeg,.png,.pdf">
                                    <label for="receipt_file" class="d-block mb-1 text-primary cursor-pointer" style="cursor: pointer;">Choose New File (Optional)</label>
                                    <div class="small text-muted" id="file_name_display">JPG, PNG, PDF | Max 2MB</div>
                                </div>
                                
                                @if($anshandan->receipt_file)
                                <div class="alert alert-info border-0 shadow-sm d-flex align-items-center" style="border-radius: 10px;">
                                    <i class="fas fa-paperclip me-3 fa-lg"></i>
                                    <div>
                                        <div class="small fw-bold">Current Attachment:</div>
                                        <a href="{{ asset('storage/' . $anshandan->receipt_file) }}" target="_blank" class="alert-link small">View Existing Receipt</a>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-12 mt-4">
                                <label class="form-label small fw-bold text-muted">Remarks / Notes</label>
                                <textarea name="remarks" class="form-control border-0 shadow-sm" rows="3" style="border-radius: 12px;">{{ old('remarks', $anshandan->remarks) }}</textarea>
                            </div>

                            <div class="col-12 mt-5 text-center">
                                <hr class="my-4">
                                <a href="{{ route('admin.anshandan.index') }}" class="btn btn-light px-5 py-2 me-2" style="border-radius: 10px;">Cancel</a>
                                <button type="submit" class="btn btn-primary px-5 py-2 shadow-sm" style="background: linear-gradient(135deg, #6f42c1 0%, #a29bfe 100%); border: 0; border-radius: 10px; min-width: 200px;">Update Contribution</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus { box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.15); }
    .input-group-text { font-weight: bold; }
    .cursor-pointer { cursor: pointer; }
    .file-upload-wrapper:hover { background: #f1f1f1 !important; border-color: #6f42c1 !important; }
</style>

@push('scripts')
<script>
    document.getElementById('user_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('member_name').value = selectedOption.dataset.name;
        }
    });

    document.getElementById('receipt_file').addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            document.getElementById('file_name_display').innerText = 'Selected: ' + this.files[0].name;
            document.getElementById('file_name_display').classList.add('text-primary', 'fw-bold');
        }
    });
</script>
@endpush

@endsection
