@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Sanctioned Post</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="designation_id">Designation <span class="text-danger">*</span></label>
                            <select name="designation_id" id="designation_id" class="form-control @error('designation_id') is-invalid @enderror" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('designation_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="level">Level <span class="text-danger">*</span></label>
                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required onchange="toggleLevelFields()">
                                <option value="">Select Level</option>
                                <option value="state" {{ old('level') == 'state' ? 'selected' : '' }}>State</option>
                                <option value="division" {{ old('level') == 'division' ? 'selected' : '' }}>Division</option>
                                <option value="district" {{ old('level') == 'district' ? 'selected' : '' }}>District</option>
                                <option value="school" {{ old('level') == 'school' ? 'selected' : '' }}>School</option>
                            </select>
                            @error('level')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3" id="division_field" style="display: none;">
                            <label for="division_id">Division</label>
                            <select name="division_id" id="division_id" class="form-control">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3" id="district_field" style="display: none;">
                            <label for="district_id">District</label>
                            <select name="district_id" id="district_id" class="form-control">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Note: For schools, in a real app you'd use a search/autocomplete. 
                             Here we'll hide it or provide a text input for ID if list is too long, 
                             but adhering to controller's simple logic for now. 
                             Assuming user will just select District/Division for general posts 
                             or we'd need a school picker. 
                             For this task, I'll add a simple input field for School ID as a placeholder for a complex picker -->
                        <div class="form-group mb-3" id="school_field" style="display: none;">
                             <div class="alert alert-info">For School posts, please ensure you have the School ID. (UI simplified for prototype)</div>
                             <label for="school_id">School ID</label>
                             <input type="number" name="school_id" id="school_id" class="form-control" value="{{ old('school_id') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="sanctioned_count">Sanctioned Count <span class="text-danger">*</span></label>
                            <input type="number" name="sanctioned_count" id="sanctioned_count" class="form-control @error('sanctioned_count') is-invalid @enderror" value="{{ old('sanctioned_count', 1) }}" min="1" required>
                            @error('sanctioned_count')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Post</button>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleLevelFields() {
    const level = document.getElementById('level').value;
    document.getElementById('division_field').style.display = (level === 'division') ? 'block' : 'none';
    document.getElementById('district_field').style.display = (level === 'district') ? 'block' : 'none';
    document.getElementById('school_field').style.display = (level === 'school') ? 'block' : 'none';
}
window.onload = toggleLevelFields;
</script>
@endsection
