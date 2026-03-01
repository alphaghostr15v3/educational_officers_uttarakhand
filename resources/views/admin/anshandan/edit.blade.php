@extends('layouts.admin')

@section('page_title', 'Edit Contribution')

@section('admin_content')
<div class="container-fluid mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Main Form Card -->
            <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px; overflow: hidden;">
                <!-- Purple Header -->
                <div class="card-header py-3 d-flex align-items-center justify-content-between" style="background: #6f42c1; color: white; border-bottom: 0;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit me-2"></i>
                        <h6 class="mb-0 fw-bold">Edit Anshandan Receipt: {{ $anshandan->receipt_no }}</h6>
                    </div>
                    <a href="{{ route('admin.anshandan.index') }}" class="btn btn-sm btn-light border-0 px-3" style="border-radius: 8px; color: #6f42c1; font-weight: bold;">Back to List</a>
                </div>
                
                <div class="card-body p-4 bg-white">
                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 8px;">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.anshandan.update', $anshandan->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <!-- Section 1: Member Information -->
                            <div class="col-12 mt-2 mb-1">
                                <h6 class="fw-bold" style="color: #4361ee;">
                                    <i class="fas fa-user-circle me-2"></i>Member Information
                                </h6>
                            </div>

                            <div class="col-md-7">
                                <label class="form-label small fw-bold text-muted">Select Member (Optional)</label>
                                <select name="user_id" id="user_id" class="form-select border shadow-none" style="border-radius: 8px; background-color: #fcfcfc;">
                                    <option value="">-- Choose Member --</option>
                                    @foreach($members as $member)
                                        <option value="{{ $member->id }}" data-name="{{ $member->name }}" data-school="{{ $member->staff->school->name ?? '' }}" {{ $anshandan->user_id == $member->id ? 'selected' : '' }}>
                                            {{ $member->name }} ({{ $member->employee_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label small fw-bold text-muted">Member Name <span class="text-danger">*</span></label>
                                <input type="text" name="member_name" id="member_name" class="form-control border shadow-none" required value="{{ old('member_name', $anshandan->member_name) }}" style="border-radius: 8px; background-color: #fcfcfc;">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label small fw-bold text-muted">Depositor Name <span class="text-danger">*</span></label>
                                <input type="text" name="depositor_name" id="depositor_name" class="form-control border shadow-none" placeholder="Enter Name of Person Depositing" required value="{{ old('depositor_name', $anshandan->depositor_name) }}" style="border-radius: 8px; background-color: #fcfcfc;">
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label small fw-bold text-muted">School / Office <span class="text-danger">*</span></label>
                                <select name="school_office" id="school_office" class="form-select select2 border shadow-none" required style="border-radius: 8px; background-color: #fcfcfc;">
                                    <option value="">-- Select School/Office --</option>
                                    @foreach($schools as $school)
                                        <option value="{{ $school->name }}" {{ old('school_office', $anshandan->school_office) == $school->name ? 'selected' : '' }}>{{ $school->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Section 2: Contribution Details -->
                            <div class="col-12 mt-4 mb-1">
                                <h6 class="fw-bold" style="color: #4361ee;">
                                    <i class="fas fa-id-card me-2"></i>Contribution Details
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Amount (₹) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted">₹</span>
                                    <input type="number" name="amount" class="form-control border-start-0 shadow-none ps-0" step="0.01" required value="{{ old('amount', $anshandan->amount) }}" style="border-radius: 0 8px 8px 0; background-color: #fcfcfc;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Receipt Number <span class="text-danger">*</span></label>
                                <input type="text" name="receipt_no" class="form-control border shadow-none bg-light" required value="{{ old('receipt_no', $anshandan->receipt_no) }}" style="border-radius: 8px;" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Date <span class="text-danger">*</span></label>
                                <input type="date" name="payment_date" class="form-control border shadow-none" required value="{{ old('payment_date', $anshandan->payment_date) }}" style="border-radius: 8px; background-color: #fcfcfc;">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Month <span class="text-danger">*</span></label>
                                <select name="month" class="form-select border shadow-none" required style="border-radius: 8px; background-color: #fcfcfc;">
                                    @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                        <option value="{{ $m }}" {{ (old('month', $anshandan->month) == $m) ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Year <span class="text-danger">*</span></label>
                                <input type="number" name="year" class="form-control border shadow-none" required value="{{ old('year', $anshandan->year) }}" style="border-radius: 8px; background-color: #fcfcfc;">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Academic Year</label>
                                <input type="text" name="academic_year" class="form-control border shadow-none" placeholder="2025-2026" value="{{ old('academic_year', $anshandan->academic_year) }}" style="border-radius: 8px; background-color: #fcfcfc;">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-select border shadow-none" required style="border-radius: 8px; background-color: #fcfcfc;">
                                    <option value="Cash" {{ $anshandan->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Online" {{ $anshandan->payment_method == 'Online' ? 'selected' : '' }}>Online Transfer</option>
                                    <option value="Cheque" {{ $anshandan->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                </select>
                            </div>

                            <!-- Section 3: Upload -->
                            <div class="col-12 mt-4 mt-2">
                                <label class="form-label small fw-bold text-muted">Update Attachment</label>
                                <div class="upload-area text-center py-4 border rounded" style="background-color: #f8f9fa; border-style: dashed !important; border-width: 2px !important;">
                                    <i class="fas fa-file-upload fa-2x text-secondary mb-2"></i>
                                    <input type="file" name="receipt_file" class="d-none" id="receipt_file" accept=".jpg,.jpeg,.png,.pdf">
                                    <div>
                                        <label for="receipt_file" class="text-primary fw-bold" style="cursor: pointer;">Choose New File (Optional)</label>
                                    </div>
                                    <p class="small text-muted mb-0" id="file_name_display">JPG, PNG, PDF | Max 2MB</p>
                                </div>
                                
                                @if($anshandan->receipt_file)
                                <div class="mt-3 p-3 border rounded-3 d-flex align-items-center bg-light">
                                    <i class="fas fa-paperclip me-3 text-primary fa-lg"></i>
                                    <div>
                                        <div class="small fw-bold text-muted">Current Attachment:</div>
                                        <a href="{{ asset($anshandan->receipt_file) }}" target="_blank" class="text-primary small fw-bold">View Existing Receipt</a>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Section 4: Jurisdiction -->
                            <div class="col-12 mt-4 mb-2">
                                <h6 class="fw-bold" style="color: #4361ee;">
                                    <i class="fas fa-map-marker-alt me-2"></i>Jurisdiction Information
                                </h6>
                            </div>

                            @if(auth()->user()->role === 'admin_panel' || auth()->user()->role === 'state_admin')
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">District <span class="text-danger">*</span></label>
                                    <select name="district_id" class="form-select border shadow-none" required style="border-radius: 8px; background-color: #fcfcfc;">
                                        <option value="">-- Select District --</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id', $anshandan->district_id) == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-muted">Block (Optional)</label>
                                    <select name="block_id" class="form-select border shadow-none" style="border-radius: 8px; background-color: #fcfcfc;">
                                        <option value="">All Blocks</option>
                                        @foreach($blocks as $block)
                                            <option value="{{ $block->id }}" {{ old('block_id', $anshandan->block_id) == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif(auth()->user()->role === 'district_admin')
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-muted">Block (Optional)</label>
                                    <select name="block_id" class="form-select border shadow-none" style="border-radius: 8px; background-color: #fcfcfc;">
                                        <option value="">Current District Scale</option>
                                        @foreach($blocks as $block)
                                            <option value="{{ $block->id }}" {{ old('block_id', $anshandan->block_id) == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold text-muted">Block</label>
                                    <input type="text" class="form-control bg-light" value="{{ $anshandan->block->name ?? 'Default Block' }}" disabled style="border-radius: 8px;">
                                </div>
                            @endif

                            <!-- Section 5: Remarks -->
                            <div class="col-12 mt-4">
                                <label class="form-label small fw-bold text-muted">Remarks / Notes</label>
                                <textarea name="remarks" class="form-control border shadow-none" rows="4" style="border-radius: 8px; background-color: #fcfcfc;">{{ old('remarks', $anshandan->remarks) }}</textarea>
                            </div>

                            <!-- Footer Buttons -->
                            <div class="col-12 mt-5 py-3 border-top d-flex justify-content-center gap-3">
                                <a href="{{ route('admin.anshandan.index') }}" class="btn px-5 py-2" style="background-color: #f8f9fa; color: #333; border: 1px solid #ddd; border-radius: 10px;">Cancel</a>
                                <button type="submit" class="btn px-5 py-2 text-white" style="background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%); border: 0; border-radius: 10px;">Update Contribution</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 1px solid #dee2e6 !important;
            border-radius: 8px !important;
            height: 40px !important;
            padding: 5px !important;
            background-color: #fcfcfc !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6c5ce7 !important;
            box-shadow: none !important;
        }
        .upload-area:hover {
            background-color: #f1f3f5 !important;
        }
        .form-label span.text-danger { font-size: 1.1rem; }
    </style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'default',
            width: '100%',
            placeholder: '-- Select School/Office --',
            tags: true // Allow new entries
        });

        // Autofill name and school from member selection
        $('#user_id').on('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const memberName = selectedOption.dataset.name;
                $('#member_name').val(memberName);
                $('#depositor_name').val(memberName); // Also autofill depositor name
                
                // Set school_office dropdown value and trigger change for Select2
                const schoolName = selectedOption.dataset.school;
                if (schoolName) {
                    $('#school_office').val(schoolName).trigger('change');
                }
            }
        });

        // File display name update
        $('#receipt_file').on('change', function() {
            if (this.files && this.files.length > 0) {
                $('#file_name_display').text('Selected: ' + this.files[0].name)
                    .addClass('text-primary fw-bold');
            }
        });
    });
</script>
@endpush

@endsection
