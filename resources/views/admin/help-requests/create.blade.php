@extends('layouts.admin')

@section('page_title', 'Submit State Level Help Request')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.help-requests.store') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted text-uppercase">Target Level</label>
                                <select name="target_level" id="target_level" class="form-select @error('target_level') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select Target Level</option>
                                    <option value="state">State Admin (Highest Level)</option>
                                    <option value="division">Specific Division Admin</option>
                                    <option value="district">Specific District Admin</option>
                                    <option value="block">Specific Block Admin</option>
                                </select>
                                @error('target_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6" id="target_unit_container" style="display: none;">
                                <label class="form-label fw-bold small text-muted text-uppercase" id="target_unit_label">Select Unit</label>
                                
                                <!-- Division Selection -->
                                <select name="target_id" id="select_division" class="form-select unit-selector" style="display: none;">
                                    <option value="" selected disabled>Select Division</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>

                                <!-- District Selection -->
                                <select name="target_id" id="select_district" class="form-select unit-selector" style="display: none;">
                                    <option value="" selected disabled>Select District</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>

                                <!-- Block Selection -->
                                <select name="target_id" id="select_block" class="form-select unit-selector" style="display: none;">
                                    <option value="" selected disabled>Select Block</option>
                                    @foreach($blocks as $block)
                                        <option value="{{ $block->id }}">{{ $block->name }} ({{ $block->district->name ?? 'N/A' }})</option>
                                    @endforeach
                                </select>

                                @error('target_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Subject</label>
                            <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Brief summary of your query" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Detail Message</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="6" placeholder="Describe your issue or request in detail..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.help-requests.index') }}" class="btn btn-light border px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-paper-plane me-2"></i>Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info text-white p-2">
                <div class="card-body">
                    <h5 class="fw-bold mb-3"><i class="fas fa-shield-alt me-2"></i>State Admin Tool</h5>
                    <p class="small mb-0 opacity-75">
                        As a State Admin, you can use this form to escalate issues or send formal queries to specific divisions, districts, or blocks. 
                        Your requests will be tagged as coming from the State level.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const targetLevel = document.getElementById('target_level');
    const unitContainer = document.getElementById('target_unit_container');
    const unitLabel = document.getElementById('target_unit_label');
    const unitSelectors = document.querySelectorAll('.unit-selector');

    targetLevel.addEventListener('change', function() {
        const value = this.value;
        
        // Hide all unit selectors first
        unitSelectors.forEach(sel => {
            sel.style.display = 'none';
            sel.required = false;
            sel.disabled = true;
        });

        if (value === 'state' || value === '') {
            unitContainer.style.display = 'none';
        } else {
            unitContainer.style.display = 'block';
            unitLabel.textContent = 'Select ' + value.charAt(0).toUpperCase() + value.slice(1);
            
            const activeSelector = document.getElementById('select_' + value);
            if (activeSelector) {
                activeSelector.style.display = 'block';
                activeSelector.required = true;
                activeSelector.disabled = false;
                activeSelector.value = ""; // Reset
            }
        }
    });
});
</script>
@endsection
