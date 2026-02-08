@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Designation: {{ $designation->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.designations.update', $designation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="name">Designation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $designation->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="level">Level <span class="text-danger">*</span></label>
                            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                <option value="">Select Level</option>
                                <option value="state" {{ old('level', $designation->level) == 'state' ? 'selected' : '' }}>State</option>
                                <option value="division" {{ old('level', $designation->level) == 'division' ? 'selected' : '' }}>Division</option>
                                <option value="district" {{ old('level', $designation->level) == 'district' ? 'selected' : '' }}>District</option>
                                <option value="school" {{ old('level', $designation->level) == 'school' ? 'selected' : '' }}>School</option>
                            </select>
                            @error('level')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="parent_id">Parent Designation (Reports to)</label>
                            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                <option value="">None (Top Level)</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $designation->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} ({{ ucfirst($parent->level) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="order">Sort Order</label>
                            <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', $designation->order) }}" min="0">
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $designation->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Designation</button>
                            <a href="{{ route('admin.designations.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
