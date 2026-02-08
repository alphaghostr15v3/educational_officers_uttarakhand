@extends('layouts.public')

@section('content')
<!-- Birthday Hero Carousel -->
<div id="birthdayHeroCarousel" class="carousel slide carousel-fade hero-carousel-custom" data-bs-ride="carousel" data-bs-interval="5000">
    @if($today_birthdays->count() > 0)
        <!-- Indicators -->
        @if($today_birthdays->count() > 1)
            <div class="carousel-indicators">
                @foreach($today_birthdays as $index => $birthday)
                    <button type="button" data-bs-target="#birthdayHeroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
        @endif

        <div class="carousel-inner">
            @foreach($today_birthdays as $index => $birthday)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="hero-split-slide">
                        <div class="hero-split-text animate__animated animate__fadeIn">
                            <div class="breadcrumb-slider">
                                <a href="{{ url('/') }}">Home</a>
                                <span class="separator">></span>
                                <span>Birthdays This Month</span>
                                @if($birthday->dob->isBirthday())
                                    <span class="badge bg-danger ms-2 animate__animated animate__pulse animate__infinite">TODAY</span>
                                @endif
                            </div>
                            
                            <h1 class="animate__animated animate__fadeInDown text-uppercase">{{ $birthday->name }}</h1>
                            <p class="animate__animated animate__fadeInUp mb-1">{{ $birthday->designation }}</p>
                            <h4 class="text-warning mb-4 animate__animated animate__fadeInUp">
                                <i class="fas fa-gift me-2"></i> Birthday: {{ $birthday->dob->format('d F') }}
                            </h4>
                            
                            <div class="d-flex gap-3 animate__animated animate__zoomIn">
                                <a href="{{ route('home') }}" class="btn btn-warning btn-lg px-4 fw-bold">Back to Home</a>
                                <div class="badge bg-white bg-opacity-10 border border-white border-opacity-25 p-3 rounded d-flex align-items-center">
                                    <i class="fas fa-birthday-cake fa-2x me-3 text-warning"></i>
                                    <div class="text-start">
                                        <div class="small opacity-75">Celebrating</div>
                                        <div class="fw-bold fs-5">{{ now()->format('F Y') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero-split-image" style="background-image: url('{{ $birthday->image_url }}');"></div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($today_birthdays->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#birthdayHeroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#birthdayHeroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        @endif
    @else
        <!-- Fallback if no birthdays -->
        <div class="hero-split-slide">
            <div class="hero-split-text">
                <div class="breadcrumb-slider">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="separator">></span>
                    <span>No Celebrations</span>
                </div>
                <h1>No Birthdays This Month</h1>
                <p>Stay tuned for upcoming employee celebrations.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('home') }}" class="btn btn-warning btn-lg px-4 fw-bold">Back to Home</a>
                </div>
            </div>
            <div class="hero-split-image" style="background-image: url('https://images.unsplash.com/photo-1513151233558-d860c5398176?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
        </div>
    @endif
</div>

<style>
    /* Specific overrides for Birthday Page Slider */
    .hero-carousel-custom .carousel-item {
        height: 700px; /* Taller for dedicated page */
    }
    .hero-split-slide {
        height: 700px;
        background: linear-gradient(135deg, #001a33 0%, #003057 100%);
    }
    .hero-split-text h1 {
        font-size: 5rem;
        line-height: 1;
        margin-bottom: 15px;
    }
    .hero-split-image {
        clip-path: ellipse(80% 110% at 90% 50%);
    }
    @media (max-width: 992px) {
        .hero-split-text h1 {
            font-size: 3.5rem;
        }
        .hero-carousel-custom .carousel-item, .hero-split-slide {
            height: auto;
            min-height: 600px;
        }
    }
</style>
@endsection

