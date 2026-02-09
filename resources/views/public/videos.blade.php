@extends('layouts.public')

@section('page_title', 'Videos - EMOU Uttarakhand')

@section('content')
<div class="py-5 bg-white">
    <div class="container">
        <div class="media-page-header text-center mb-5">
            <span class="media-page-label">Videos</span>
            <h1 class="media-page-title">Videos</h1>
            <p class="media-page-description">Watch videos of past events, workshops, and seminars organized by the Educational Ministerial Officers Association, Uttarakhand.</p>
        </div>

        <div class="row g-4" id="videoGrid">
            @forelse($videos as $video)
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden video-card cursor-pointer" 
                        data-title="{{ $video->title }}"
                        data-url="{{ $video->video_url }}"
                        data-file="{{ $video->video_file_path ? asset('uploads/videos/files/' . $video->video_file_path) : '' }}"
                        onclick="playVideoInline(this)">
                        <div class="video-container position-relative">
                            <div class="media-wrapper" style="height: 220px;">
                                @if($video->thumbnail_path)
                                    <img src="{{ asset('uploads/videos/' . $video->thumbnail_path) }}" class="card-img-top w-100 h-100" alt="{{ $video->title }}" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center w-100 h-100">
                                        <i class="fas fa-video fa-3x text-white opacity-50"></i>
                                    </div>
                                @endif
                                <div class="video-duration-badge">
                                    {{ $video->duration ?? '10:00' }}
                                </div>
                            </div>
                            <div class="video-overlay d-flex align-items-center justify-content-center">
                                <div class="play-icon-circle">
                                    <i class="fas fa-play text-white ms-1"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-2" style="color: #2c3e50;">{{ $video->title }}</h5>
                            <div class="small text-muted mb-0">
                                <i class="far fa-calendar-alt me-1"></i> {{ $video->created_at->format('F d, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-video fa-4x text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No videos available at the moment.</h5>
                    <p class="text-muted small">Videos will be added soon. Please check back later.</p>
                </div>
            @endforelse
        </div>

        @if($videos->hasPages())
            <div class="mt-5 d-flex justify-content-center">
                {{ $videos->links() }}
            </div>
        @endif
    </div>
</div>

<style>
    .video-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
    }
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .video-duration-badge {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        z-index: 2;
    }
    .video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.2);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .video-card:hover .video-overlay {
        opacity: 1;
    }
    .play-icon-circle {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border: 2px solid white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: transform 0.2s ease;
    }
    .video-card:hover .play-icon-circle {
        transform: scale(1.1);
        background: white;
    }
    .video-card:hover .play-icon-circle i {
        color: var(--uk-blue) !important;
    }
    .video-playing .video-overlay,
    .video-playing .video-duration-badge {
        display: none !important;
    }
</style>

@push('scripts')
<script>
    function playVideoInline(card) {
        // Find the container
        const container = card.querySelector('.video-container');
        const url = card.getAttribute('data-url');
        const file = card.getAttribute('data-file');
        
        // Don't restart if already playing
        if (card.classList.contains('video-playing')) return;

        // Stop other videos playing in the grid
        document.querySelectorAll('.video-playing').forEach(activeCard => {
            const activeContainer = activeCard.querySelector('.video-container');
            const originalHtml = activeCard.getAttribute('data-original-media');
            if (originalHtml) {
                activeContainer.innerHTML = originalHtml;
                activeCard.classList.remove('video-playing');
            }
        });

        // Store original media to restore later if needed
        const originalMedia = container.innerHTML;
        card.setAttribute('data-original-media', originalMedia);
        card.classList.add('video-playing');

        let html = '';
        if (file) {
            html = `<div style="height: 220px; background: #000;">
                        <video controls autoplay class="w-100 h-100">
                            <source src="${file}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>`;
        } else if (url) {
            let videoId = '';
            if (url.includes('youtube.com') || url.includes('youtu.be')) {
                if (url.includes('v=')) {
                    videoId = url.split('v=')[1].split('&')[0];
                } else {
                    videoId = url.split('/').pop().split('?')[0];
                }
                html = `<div class="ratio ratio-16x9" style="height: 220px; background: #000;">
                            <iframe src="https://www.youtube.com/embed/${videoId}?autoplay=1" allowfullscreen allow="autoplay"></iframe>
                        </div>`;
            } else if (url.includes('vimeo.com')) {
                videoId = url.split('/').pop().split('?')[0];
                html = `<div class="ratio ratio-16x9" style="height: 220px; background: #000;">
                            <iframe src="https://player.vimeo.com/video/${videoId}?autoplay=1" allowfullscreen allow="autoplay"></iframe>
                        </div>`;
            } else {
                html = `<div class="ratio ratio-16x9" style="height: 220px; background: #000;">
                            <iframe src="${url}" allowfullscreen></iframe>
                        </div>`;
            }
        }

        if (html) {
            container.innerHTML = html;
        }
    }
</script>
@endpush
@endsection
