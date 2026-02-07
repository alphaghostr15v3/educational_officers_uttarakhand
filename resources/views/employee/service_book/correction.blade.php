@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row mb-4 align-items-center">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('employee.service-book') }}">Service Book</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Request Correction</li>
                        </ol>
                    </nav>
                    <h1 class="h3 mb-0 fw-bold">Request Data Correction</h1>
                    <p class="text-muted">If you find any incorrect information in your Service Book, please specify here.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm border-start border-danger border-4">
                <div class="card-body p-4">
                    <form action="{{ route('employee.service-book.correction.submit') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="field_name" class="form-label fw-bold">Information Category / Field Name</label>
                            <select class="form-select @error('field_name') is-invalid @enderror" id="field_name" name="field_name" required>
                                <option value="" selected disabled>Select Field...</option>
                                <optgroup label="Personal Details">
                                    <option value="Name">Name</option>
                                    <option value="Mobile">Mobile Number</option>
                                    <option value="Email">Email Address</option>
                                    <option value="Employee Code">Employee Code</option>
                                </optgroup>
                                <optgroup label="Posting Details">
                                    <option value="Current Designation">Current Designation</option>
                                    <option value="Joining Date">Joining Date</option>
                                    <option value="Retirement Date">Retirement Date</option>
                                    <option value="Current School/Office">Current School/Office</option>
                                </optgroup>
                                <optgroup label="Other">
                                    <option value="Other">Other (Specify in reason)</option>
                                </optgroup>
                            </select>
                            @error('field_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="current_value" class="form-label fw-bold">Current (Incorrect) Value</label>
                                <input type="text" class="form-control @error('current_value') is-invalid @enderror" id="current_value" name="current_value" placeholder="Enter value as shown now" required>
                                @error('current_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="suggested_value" class="form-label fw-bold">Correct / Suggested Value</label>
                                <input type="text" class="form-control @error('suggested_value') is-invalid @enderror" id="suggested_value" name="suggested_value" placeholder="Enter the correct value" required>
                                @error('suggested_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reason" class="form-label fw-bold">Reason & Supporting Evidence Reference</label>
                            <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="4" placeholder="Briefly explain the correct data and mention any supporting order/document number..." required minlength="10"></textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger py-2">
                                <i class="fas fa-paper-plane me-2"></i> Submit Correction Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="alert alert-info mt-4 border-0 shadow-sm">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle fa-2x mt-1"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="fw-bold">Note on Correction Process</h6>
                        <p class="small mb-0 text-muted">Correction requests are forwarded to the District Admin for verification. You will be notified once the data is updated. Please ensure you have supporting documents (Uploads) available for the admin to verify.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
