@extends('layouts.public')

@section('page_title', 'Photo Gallery - EMOU Uttarakhand')

@section('content')
<div class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5 text-center">
            <div class="col-lg-8 mx-auto">
                <h6 class="text-uppercase fw-bold text-primary mb-2" style="letter-spacing: 2px;">Visual Memories</h6>
                <h2 class="display-5 fw-bold mb-3">Photo Gallery</h2>
                <div class="uk-saffron-line mx-auto mb-4" style="width: 80px; height: 4px; background: var(--uk-saffron);"></div>
                <p class="text-muted lead">Capturing moments and events of Educational Ministerial Officers Association, Uttarakhand.</p>
            </div>
        </div>

        <div class="row g-4" id="galleryGrid">
            @forelse($photos as $photo)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden gallery-card">
                        <a href="{{ asset('storage/' . $photo->image_path) }}" target="_blank" class="gallery-item">
                            <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}" style="height: 200px; object-fit: cover;">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus text-white fa-2x"></i>
                            </div>
                        </a>
                        <div class="card-body p-3 text-center">
                            <h6 class="fw-bold mb-1 text-truncate">{{ $photo->title }}</h6>
                            <span class="badge bg-light text-primary border border-primary-subtle rounded-pill small">{{ $photo->category }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-images fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No photos found in the gallery.</h5>
                </div>
            @endforelse
        </div>

        @if($photos->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $photos->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .gallery-card {
        transition: transform 0.3s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
    }
    .gallery-item {
        position: relative;
        display: block;
    }
    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
</style>
@endsection
