@extends('layouts.admin')

@section('page_title', 'Add Hero Slide')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Create New Slide</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.hero-slides.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Professional Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" required>
                        <div class="form-text text-muted small">Recommended size: 1920x600px or higher. Max 5MB.</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Main Title</label>
                            <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g. Welcome to Ministerial Officers Portal">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Subtitle / Lead Text</label>
                            <textarea name="subtitle" class="form-control" rows="2" placeholder="e.g. Department of Education, Uttarakhand">{{ old('subtitle') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Button Link (URL)</label>
                            <input type="url" name="link" class="form-control" value="{{ old('link') }}" placeholder="https://...">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
                                <label class="form-check-label">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                        <a href="{{ route('admin.hero-slides.index') }}" class="btn btn-light px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-5">Save Slide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
