@extends('layouts.frontend_admin')

@section('admin_title', 'Hero Slider Management')

@section('frontend_admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Dynamic Slider Management</h4>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary fw-bold px-4 rounded-pill">
        <i class="fas fa-plus me-2"></i> Add New Slide
    </a>
</div>

<p class="text-muted small mb-4">
    Manage the high-impact photos that appear on your homepage. Drag-and-drop sorting (coming soon) or use sort orders to organize.
</p>

<div class="row g-4">
    @forelse($slides as $slide)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 overflow-hidden">
            <div style="position: relative; height: 160px;">
                <img src="{{ $slide->image_url }}" class="w-100 h-100" style="object-fit: cover;">
                <div style="position: absolute; top: 10px; right: 10px;">
                    @if($slide->is_active)
                        <span class="badge bg-success rounded-pill px-3 shadow-sm border border-2 border-white">Active</span>
                    @else
                        <span class="badge bg-secondary rounded-pill px-3 shadow-sm border border-2 border-white">Hidden</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold mb-0 text-truncate" style="max-width: 150px;">{{ $slide->title ?? 'Untitled Slide' }}</h6>
                    <span class="badge bg-light text-dark border small">#{{ $slide->sort_order }}</span>
                </div>
                <p class="text-muted small mb-3 text-truncate">{{ $slide->subtitle ?? 'No subtitle provided.' }}</p>
                
                <div class="d-flex gap-2 border-top pt-3">
                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-outline-info btn-sm flex-grow-1 fw-bold">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Remove this slide?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-bold">
                            <i class="fas fa-trash me-1"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5 bg-light rounded">
        <i class="fas fa-images fa-4x text-muted mb-3 opacity-25"></i>
        <h5 class="text-muted">No slider images found.</h5>
        <p class="text-muted small">Upload professional photos to enhance your homepage experience.</p>
    </div>
    @endforelse
</div>
@endsection
