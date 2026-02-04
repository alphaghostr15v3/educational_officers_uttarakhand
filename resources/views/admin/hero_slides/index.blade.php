@extends('layouts.admin')

@section('page_title', 'Manage Hero Sliders')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Hero Slides List</h6>
        <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-plus me-1"></i> Add New Slide
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 100px;">Slide</th>
                        <th>Title & Subtitle</th>
                        <th class="text-center">Order</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($slides as $slide)
                    <tr>
                        <td class="ps-4">
                            <img src="{{ $slide->image_url }}" class="rounded shadow-sm" style="width: 80px; height: 45px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $slide->title ?? 'Untitled' }}</div>
                            <div class="text-muted small">{{ $slide->subtitle ?? 'No subtitle' }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $slide->sort_order }}</span>
                        </td>
                        <td class="text-center">
                            @if($slide->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('admin.hero-slides.edit', $slide) }}"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slide?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fas fa-trash-alt me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No hero slides found. Add some to make the homepage professional.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
