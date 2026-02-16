@extends('layouts.public')

@section('page_title', 'Photo Gallery - EMOU Uttarakhand')

@section('content')
<div class="py-5 bg-white">
    <div class="container">
        <div class="media-page-header text-center mb-5">
            <span class="media-page-label">Gallery</span>
            <h1 class="media-page-title">Gallery</h1>
            <p class="media-page-description">Explore moments from the events held by the Educational Ministerial Officers Association, Uttarakhand.</p>
        </div>

        <div class="row g-4" id="galleryGrid">
            @forelse($photos as $index => $photo)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden gallery-card cursor-pointer" 
                        onclick="openLightbox({{ $photo->id }})"
                        data-id="{{ $photo->id }}"
                        data-src="{{ asset('uploads/gallery/' . $photo->image_path) }}" 
                        data-title="{{ $photo->title }}"
                        data-photos="{{ json_encode($photo->photos) }}">
                        <div class="gallery-item">
                            <img src="{{ asset('uploads/gallery/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}" style="height: 200px; object-fit: cover;">
                            <div class="gallery-overlay">
                                <i class="fas fa-search-plus text-white fa-2x"></i>
                            </div>
                        </div>
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

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                
                <div class="text-center">
                    <img id="lightboxImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; object-fit: contain;">
                    <div class="mt-3 text-white">
                        <h5 id="lightboxTitle" class="fw-bold"></h5>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <button class="btn btn-link text-white position-absolute top-50 start-0 translate-middle-y fs-1 text-decoration-none" onclick="prevImage()" style="left: -50px !important;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="btn btn-link text-white position-absolute top-50 end-0 translate-middle-y fs-1 text-decoration-none" onclick="nextImage()" style="right: -50px !important;">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .gallery-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .cursor-pointer {
        cursor: pointer;
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
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    #lightboxModal .modal-xl {
        max-width: 90%;
    }
</style>

@push('scripts')
<script>
    let currentAlbum = [];
    let currentPhotoIndex = 0;
    let lightboxModal;

    document.addEventListener('DOMContentLoaded', function() {
        lightboxModal = new bootstrap.Modal(document.getElementById('lightboxModal'));

        // Keyboard Navigation
        document.addEventListener('keydown', function(e) {
            if (!document.getElementById('lightboxModal').classList.contains('show')) return;
            
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'ArrowRight') nextImage();
        });
    });

    function openLightbox(galleryId) {
        const card = document.querySelector(`.gallery-card[data-id="${galleryId}"]`);
        const title = card.getAttribute('data-title');
        const mainSrc = card.getAttribute('data-src');
        
        // Get inner photos from the data attribute
        const innerPhotos = JSON.parse(card.getAttribute('data-photos'));
        
        // Build the album: Main photo + Inner photos
        currentAlbum = [
            { src: mainSrc, title: title }
        ];
        
        innerPhotos.forEach(photo => {
            currentAlbum.push({
                src: "{{ asset('uploads/gallery') }}/" + photo.photo_path,
                title: title
            });
        });

        currentPhotoIndex = 0;
        updateLightbox();
        lightboxModal.show();

        // Show/Hide navigation based on album size
        const navBtns = document.querySelectorAll('#lightboxModal .btn-link');
        if (currentAlbum.length > 1) {
            navBtns.forEach(btn => btn.style.display = 'block');
        } else {
            navBtns.forEach(btn => btn.style.display = 'none');
        }
    }

    function updateLightbox() {
        const item = currentAlbum[currentPhotoIndex];
        document.getElementById('lightboxImage').src = item.src;
        document.getElementById('lightboxTitle').textContent = item.title + (currentAlbum.length > 1 ? ` (${currentPhotoIndex + 1}/${currentAlbum.length})` : '');
    }

    function nextImage() {
        if (currentAlbum.length <= 1) return;
        currentPhotoIndex = (currentPhotoIndex + 1) % currentAlbum.length;
        updateLightbox();
    }

    function prevImage() {
        if (currentAlbum.length <= 1) return;
        currentPhotoIndex = (currentPhotoIndex - 1 + currentAlbum.length) % currentAlbum.length;
        updateLightbox();
    }
</script>
@endpush
@endsection
