@extends('layouts.admin')

@section('page_title', 'Edit Ticker Item')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="fas fa-edit me-2 text-success"></i> Edit Ticker Item</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.ticker.update', $ticker->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Ticker Text <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $ticker->title) }}" required maxlength="255">
                        <div class="form-text">Keep it concise for better readability in the scrolling ticker.</div>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="publish_date" class="form-label fw-bold">Publish Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('publish_date') is-invalid @enderror" id="publish_date" name="publish_date" value="{{ old('publish_date', \Carbon\Carbon::parse($ticker->publish_date)->format('Y-m-d')) }}" required>
                            @error('publish_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="ticker_order" class="form-label fw-bold">Display Order (Optional)</label>
                            <input type="number" class="form-control @error('ticker_order') is-invalid @enderror" id="ticker_order" name="ticker_order" value="{{ old('ticker_order', $ticker->ticker_order) }}" min="0" placeholder="Leave empty for default">
                            <div class="form-text">Lower numbers appear first.</div>
                            @error('ticker_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Status:</strong> This ticker is currently <strong>{{ $ticker->is_published ? 'Active' : 'Inactive' }}</strong>. Use the toggle button in the list to change status.
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success py-2">
                            <i class="fas fa-save me-2"></i> Update Ticker Item
                        </button>
                        <a href="{{ route('admin.ticker.index') }}" class="btn btn-outline-secondary py-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
