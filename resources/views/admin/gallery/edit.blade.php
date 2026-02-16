@extends('layouts.admin')

@section('page_title', 'Edit Gallery Album')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2 text-primary"></i> Edit Gallery Album: {{ $gallery->title }}</h5>
                <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Gallery
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">Album Title / Caption</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $gallery->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="category" class="form-label fw-bold">Category (Optional)</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $gallery->category) }}">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-bold d-block">Current Cover Photo</label>
                            <img src="{{ asset('uploads/gallery/' . $gallery->image_path) }}" class="img-thumbnail mb-2" style="max-height: 150px;">
                            <div class="mb-4">
                                <label for="image" class="form-label fw-bold">Change Cover Photo (Optional)</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <div class="form-text">Max size: 2MB.</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="fas fa-images me-2"></i> Inner Photos</label>
                        <div class="row g-3 mb-3">
                            @foreach($gallery->photos as $photo)
                                <div class="col-md-2 col-sm-4">
                                    <div class="position-relative">
                                        <img src="{{ asset('uploads/gallery/' . $photo->photo_path) }}" class="img-fluid rounded border shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">
                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1" 
                                                onclick="removeInnerPhoto({{ $photo->id }})">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            @if($gallery->photos->isEmpty())
                                <div class="col-12">
                                    <p class="text-muted small">No inner photos in this album yet.</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="bg-light p-3 rounded border border-dashed">
                            <label for="inner_photos" class="form-label fw-bold">Add More Inner Photos</label>
                            <input type="file" class="form-control @error('inner_photos.*') is-invalid @enderror" id="inner_photos" name="inner_photos[]" multiple accept="image/*">
                            <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> You can select multiple images at once.</div>
                            @error('inner_photos.*')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">
                            <i class="fas fa-save me-2"></i> Update Gallery Album
                        </button>
                    </div>
                </form>

                <form id="delete-photo-form" action="" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function removeInnerPhoto(photoId) {
        if (confirm('Are you sure you want to remove this photo?')) {
            const form = document.getElementById('delete-photo-form');
            form.action = "{{ url('admin/gallery/photo') }}/" + photoId;
            form.submit();
        }
    }
</script>

<style>
    .border-dashed {
        border-style: dashed !important;
    }
</style>
@endsection
