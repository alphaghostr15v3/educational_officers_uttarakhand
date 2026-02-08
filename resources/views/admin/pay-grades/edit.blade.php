@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Pay Grade: {{ $payGrade->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pay-grades.update', $payGrade) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="name">Name (e.g., Level-10) <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $payGrade->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="range">Pay Scale Range (e.g., 56100-177500) <span class="text-danger">*</span></label>
                            <input type="text" name="range" id="range" class="form-control @error('range') is-invalid @enderror" value="{{ old('range', $payGrade->range) }}" required>
                            @error('range')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="grade_pay">Grade Pay (Optional)</label>
                            <input type="text" name="grade_pay" id="grade_pay" class="form-control @error('grade_pay') is-invalid @enderror" value="{{ old('grade_pay', $payGrade->grade_pay) }}">
                            @error('grade_pay')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $payGrade->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Pay Grade</button>
                            <a href="{{ route('admin.pay-grades.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
