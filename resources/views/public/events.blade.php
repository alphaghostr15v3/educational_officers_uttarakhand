@extends('layouts.public')

@section('page_title', 'Events - EMOU Uttarakhand')

@section('content')
<div class="py-5 bg-white">
    <div class="container">
        <div class="media-page-header text-center mb-5">
            <span class="media-page-label">Upcoming & Past Events</span>
            <h1 class="media-page-title">Events</h1>
            <p class="media-page-description">Stay updated with events and activities of Educational Ministerial Officers Association, Uttarakhand.</p>
        </div>

        @if($upcoming_events->count() > 0)
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0" style="border-left: 5px solid var(--uk-orange); padding-left: 15px; color: #2c3e50;">Upcoming Events</h3>
            </div>
            
            <div class="row g-4">
                @foreach($upcoming_events as $event)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm overflow-hidden event-horizontal-card">
                            <div class="row g-0">
                                <div class="col-md-5 position-relative">
                                    @if($event->image_path)
                                        <img src="{{ asset('uploads/events/' . $event->image_path) }}" class="img-fluid h-100" alt="{{ $event->title }}" style="object-fit: cover; min-height: 250px; width: 100%;">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center h-100" style="min-height: 250px;">
                                            <i class="fas fa-calendar-alt fa-3x text-white opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="event-badge-upcoming">UPCOMING</div>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body p-4 d-flex flex-column h-100">
                                        <h2 class="fw-bold mb-3" style="font-family: 'Playfair Display', serif; color: #2c3e50;">{{ $event->title }}</h2>
                                        
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2 text-muted">
                                                <i class="far fa-calendar-alt me-2 text-dark"></i>
                                                <span>{{ $event->event_date->format('F d, Y, h:i A') }}</span>
                                            </div>
                                            @if($event->location)
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="fas fa-map-marker-alt me-2 text-dark"></i>
                                                    <span>{{ $event->location }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <p class="text-muted flex-grow-1" style="font-size: 1.1rem; line-height: 1.6;">
                                            {{ Str::limit($event->description ?? 'Join us for this exciting event organized by the Educational Ministerial Officers Association, Uttarakhand.', 180) }}
                                        </p>

                                        @if($event->category)
                                            <div class="mt-3">
                                                <span class="badge rounded-pill px-3 py-2" style="background-color: rgba(39, 174, 96, 0.1); color: var(--uk-green); font-weight: 600;">{{ $event->category }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($past_events->count() > 0)
        <div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold mb-0" style="border-left: 5px solid #bdc3c7; padding-left: 15px; color: #2c3e50;">Past Events</h3>
            </div>
            
            <div class="row g-4">
                @foreach($past_events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden gallery-style-card">
                            <div class="position-relative">
                                @if($event->image_path)
                                    <img src="{{ asset('uploads/events/' . $event->image_path) }}" class="card-img-top" alt="{{ $event->title }}" style="height: 220px; object-fit: cover; filter: grayscale(30%);">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 220px;">
                                        <i class="fas fa-history fa-3x text-white opacity-50"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body p-4 text-center">
                                <h5 class="fw-bold mb-3" style="color: #2c3e50;">{{ $event->title }}</h5>
                                <div class="small text-muted mb-3 d-flex justify-content-center gap-3">
                                    <span><i class="far fa-calendar-alt me-1"></i> {{ $event->event_date->format('M d, Y') }}</span>
                                    @if($event->location)
                                        <span><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($event->location, 20) }}</span>
                                    @endif
                                </div>
                                @if($event->category)
                                    <span class="badge bg-light text-muted border rounded-pill px-3 py-2 small">{{ $event->category }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($past_events->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $past_events->links() }}
                </div>
            @endif
        </div>
        @endif

        @if($upcoming_events->count() == 0 && $past_events->count() == 0)
            <div class="col-12 text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-calendar-alt fa-4x text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted">No events scheduled at the moment.</h5>
                <p class="text-muted small">Event information will be posted here. Please check back later.</p>
            </div>
        @endif
    </div>
</div>

<style>
    .event-horizontal-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
    }
    .event-horizontal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .event-badge-upcoming {
        position: absolute;
        bottom: 20px;
        left: 20px;
        background-color: var(--uk-green);
        color: white;
        padding: 5px 15px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.8rem;
        letter-spacing: 1px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .gallery-style-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px;
    }
    .gallery-style-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection
