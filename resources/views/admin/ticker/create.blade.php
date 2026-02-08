@extends('layouts.admin')

@section('page_title', 'Add Ticker Item')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="fas fa-rss me-2 text-success"></i> Add New Ticker Item</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.ticker.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Ticker Text <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter ticker message" required maxlength="255">
                        <div class="form-text">Keep it concise for better readability in the scrolling ticker.</div>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="publish_date" class="form-label fw-bold">Publish Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ old('publish_date', date('Y-m-d')) }}" required>
                            @error('publish_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ticker_order" class="form-label fw-bold">Display Order (Optional)</label>
                            <input type="number" class="form-control @error('ticker_order') is-invalid @enderror" id="ticker_order" name="ticker_order" value="{{ old('ticker_order') }}" min="0" placeholder="Leave empty for default">
                            <div class="form-text">Lower numbers appear first.</div>
                            @error('ticker_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> This ticker item will be displayed in the green scrolling bar on the homepage.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success py-2">
                            <i class="fas fa-check me-2"></i> Create Ticker Item
                        </button>
                        <a href="{{ route('admin.ticker.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
