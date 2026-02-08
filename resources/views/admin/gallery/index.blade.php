@extends('layouts.admin')

@section('page_title', 'Photo Gallery Management')

@section('admin_content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-images me-2 text-primary"></i> Photo Gallery</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Upload New Photo
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-4">
        <div class="row g-4">
            @forelse($photos as $photo)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="gallery-item card h-100 border shadow-sm">
                    <img src="{{ asset('uploads/gallery/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1 text-truncate" title="{{ $photo->title }}">{{ $photo->title }}</h6>
                        <p class="small text-muted mb-2">Category: {{ $photo->category ?? 'General' }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <form action="{{ route('admin.gallery.toggle', $photo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $photo->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $photo->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.gallery.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Remove this photo permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 py-5 text-center">
                <div class="text-muted">
                    <i class="fas fa-camera-retro fa-3x mb-3"></i>
                    <h5>No photos in the gallery yet.</h5>
                </div>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $photos->links() }}
        </div>
    </div>
</div>
@endsection
