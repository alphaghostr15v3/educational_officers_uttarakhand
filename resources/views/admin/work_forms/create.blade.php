@extends('layouts.admin')

@section('page_title', 'Upload Work Form')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="fas fa-upload me-2 text-primary"></i> Upload New Work Form</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.work-forms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="work_type" class="form-label fw-bold">Work Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('work_type') is-invalid @enderror" id="work_type" name="work_type" required>
                            <option value="">Select Work Type</option>
                            <option value="Forms" {{ old('work_type') == 'Forms' ? 'selected' : '' }}>Forms</option>
                            <option value="Pannat" {{ old('work_type') == 'Pannat' ? 'selected' : '' }}>Pannat</option>
                            <option value="Income Tax" {{ old('work_type') == 'Income Tax' ? 'selected' : '' }}>Income Tax</option>
                            <option value="Pension Data" {{ old('work_type') == 'Pension Data' ? 'selected' : '' }}>Pension Data</option>
                            <option value="Government Orders" {{ old('work_type') == 'Government Orders' ? 'selected' : '' }}>Government Orders</option>
                            <option value="Promotion Orders" {{ old('work_type') == 'Promotion Orders' ? 'selected' : '' }}>Promotion Orders</option>
                            <option value="House Rent Allowance" {{ old('work_type') == 'House Rent Allowance' ? 'selected' : '' }}>House Rent Allowance</option>
                            <option value="Dearness Allowance Rent" {{ old('work_type') == 'Dearness Allowance Rent' ? 'selected' : '' }}>Dearness Allowance Rent</option>
                            <option value="General Provident Fund" {{ old('work_type') == 'General Provident Fund' ? 'selected' : '' }}>General Provident Fund</option>
                            <option value="Transfer Orders" {{ old('work_type') == 'Transfer Orders' ? 'selected' : '' }}>Transfer Orders</option>
                            <option value="Seniority" {{ old('work_type') == 'Seniority' ? 'selected' : '' }}>Seniority</option>
                            <option value="Bulk List" {{ old('work_type') == 'Bulk List' ? 'selected' : '' }}>Bulk List</option>
                            <option value="Tutorials" {{ old('work_type') == 'Tutorials' ? 'selected' : '' }}>Tutorials</option>
                            <option value="Ministerial Class" {{ old('work_type') == 'Ministerial Class' ? 'selected' : '' }}>Ministerial Class</option>
                            <option value="GIS Rate" {{ old('work_type') == 'GIS Rate' ? 'selected' : '' }}>GIS Rate</option>
                            <option value="Notification" {{ old('work_type') == 'Notification' ? 'selected' : '' }}>Notification</option>
                            <option value="Appointment Orders" {{ old('work_type') == 'Appointment Orders' ? 'selected' : '' }}>Appointment Orders</option>
                            <option value="Statutory Orders" {{ old('work_type') == 'Statutory Orders' ? 'selected' : '' }}>Statutory Orders</option>
                            <option value="Upgrade Letter Orders" {{ old('work_type') == 'Upgrade Letter Orders' ? 'selected' : '' }}>Upgrade Letter Orders</option>
                        </select>
                        @error('work_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4" id="sub_category_wrapper" style="display: none;">
                        <label for="sub_category" class="form-label fw-bold">Government Orders Sub-Category</label>
                        <select class="form-select @error('sub_category') is-invalid @enderror" id="sub_category" name="sub_category">
                            <option value="">Select Sub-Category</option>
                            <option value="अनुकंपा" {{ old('sub_category') == 'अनुकंपा' ? 'selected' : '' }}>अनुकंपा</option>
                            <option value="अस्थायी पेंशन" {{ old('sub_category') == 'अस्थायी पेंशन' ? 'selected' : '' }}>अस्थायी पेंशन</option>
                            <option value="सामूहिक बीमा योजना" {{ old('sub_category') == 'सामूहिक बीमा योजना' ? 'selected' : '' }}>सामूहिक बीमा योजना</option>
                            <option value="महंगाई वेतन/मानदेय" {{ old('sub_category') == 'महंगाई वेतन/मानदेय' ? 'selected' : '' }}>महंगाई वेतन/मानदेय</option>
                            <option value="पेंशन/सेवानिवृत्ति का लाभ" {{ old('sub_category') == 'पेंशन/सेवानिवृत्ति का लाभ' ? 'selected' : '' }}>पेंशन/सेवानिवृत्ति का लाभ</option>
                            <option value="वेतन पुनरीक्षण/संशोधन/उच्चीकरण" {{ old('sub_category') == 'वेतन पुनरीक्षण/संशोधन/उच्चीकरण' ? 'selected' : '' }}>वेतन पुनरीक्षण/संशोधन/उच्चीकरण</option>
                            <option value="चिकित्सा प्रतिपूर्ति" {{ old('sub_category') == 'चिकित्सा प्रतिपूर्ति' ? 'selected' : '' }}>चिकित्सा प्रतिपूर्ति</option>
                            <option value="विशेष वेतन" {{ old('sub_category') == 'विशेष वेतन' ? 'selected' : '' }}>विशेष वेतन</option>
                            <option value="ACR GO's" {{ old('sub_category') == "ACR GO's" ? 'selected' : '' }}>ACR GO's</option>
                        </select>
                        @error('sub_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Title / Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter work form title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold">Upload File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" required>
                        <div class="form-text">Allowed formats: PDF, DOC, DOCX, XLS, XLSX, ZIP (Max: 10MB)</div>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-text">Lower numbers appear first</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold d-block">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-upload me-2"></i> Upload Work Form
                        </button>
                        <a href="{{ route('admin.work-forms.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const workTypeSelect = document.getElementById('work_type');
    const subCategoryWrapper = document.getElementById('sub_category_wrapper');
    const subCategorySelect = document.getElementById('sub_category');
    
    function toggleSubCategory() {
        if (workTypeSelect.value === 'Government Orders') {
            subCategoryWrapper.style.display = 'block';
        } else {
            subCategoryWrapper.style.display = 'none';
            subCategorySelect.value = '';
        }
    }
    
    // Check on page load
    toggleSubCategory();
    
    // Check on change
    workTypeSelect.addEventListener('change', toggleSubCategory);
});
</script>
@endpush
@endsection
