@extends('layouts.admin')

@section('page_title', 'Edit Video')

@section('admin_content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="fw-bold"><i class="fas fa-video me-2 text-primary"></i> Edit Video</h4>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Video Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $video->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $video->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Video Source</label>
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="video_file" class="form-label small fw-bold">Upload New Video File</label>
                                    @if($video->video_file_path)
                                        <div class="alert alert-info py-2 small d-flex align-items-center mb-2">
                                            <i class="fas fa-file-video me-2"></i>
                                            <span>Current file: <strong>{{ $video->video_file_path }}</strong></span>
                                            <a href="{{ asset('uploads/videos/files/' . $video->video_file_path) }}" target="_blank" class="ms-auto btn btn-link btn-sm p-0">View</a>
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" id="video_file" name="video_file" accept="video/*">
                                    <small class="text-muted">Max 50MB (MP4, MOV, etc.). Leave empty to keep current file or use URL below.</small>
                                    @error('video_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-center my-2">
                                    <span class="badge bg-secondary">OR</span>
                                </div>
                                <div>
                                    <label for="video_url" class="form-label small fw-bold">Video URL</label>
                                    <input type="text" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url', $video->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                                    <small class="text-muted">Enter YouTube, Vimeo, or any video URL. (This will clear any uploaded file above on save)</small>
                                    @error('video_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label fw-bold">Thumbnail Image</label>
                        @if($video->thumbnail_path)
                            <div class="mb-2">
                                <img src="{{ asset('uploads/videos/' . $video->thumbnail_path) }}" alt="Current thumbnail" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                        <small class="text-muted">Max 2MB (JPG, PNG, GIF). Leave empty to keep current.</small>
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">Category</label>
                        <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $video->category) }}">
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label fw-bold">Sort Order</label>
                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $video->sort_order) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $video->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_active">Active</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.videos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Video
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
