@extends('layouts.admin')

@section('page_title', 'Publish News')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="fas fa-bullhorn me-2 text-primary"></i> Publish New News/Notice</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter news title" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-bold">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="6" placeholder="Write news content here..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="publish_date" class="form-label fw-bold">Publish Date</label>
                            <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ old('publish_date', date('Y-m-d')) }}" required>
                            @error('publish_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label fw-bold">Feature Image (Optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_ticker" name="is_ticker" value="1" {{ old('is_ticker') ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_ticker">Show in News Ticker (Homepage)</label>
                        </div>
                        <div class="form-text mt-1">Check this to display the news title in the scrolling bar on the main website.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="fas fa-paper-plane me-2"></i> Publish News
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
