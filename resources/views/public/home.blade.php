@extends('layouts.public')

@section('content')
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade hero-carousel-custom" data-bs-ride="carousel" data-bs-interval="5000">
    @if($hero_slides->count() > 0)
        <div class="carousel-indicators">
            @foreach($hero_slides as $index => $slide)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($hero_slides as $index => $slide)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="hero-split-slide">
                        <div class="hero-split-text animate__animated animate__fadeIn">
                            
                            <h1 class="animate__animated animate__fadeInDown">{{ $slide->title }}</h1>
                            <p class="animate__animated animate__fadeInUp">{{ $slide->subtitle }}</p>
                            
                            <div class="d-flex gap-3 animate__animated animate__zoomIn">
                                @auth
                                    <a href="{{ in_array(auth()->user()->role, ['state_admin', 'division_admin', 'district_admin']) ? route('admin.dashboard') : route('employee.dashboard') }}" class="btn btn-warning btn-lg px-4 fw-bold">Go to My Dashboard</a>
                                    <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
                                @else
                                    @if($slide->link)
                                        <a href="{{ $slide->link }}" class="btn btn-warning btn-lg px-4 fw-bold">Read More</a>
                                    @else
                                        <a href="{{ route('seniority') }}" class="btn btn-warning btn-lg px-4 fw-bold">View Seniority List</a>
                                        <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <div class="hero-split-image" style="background-image: url('{{ $slide->image_url }}');"></div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    @else
        <!-- Fallback Static Hero if no slides exist -->
        <div class="hero-split-slide">
            <div class="hero-split-text animate__animated animate__fadeIn">
                <h1 class="animate__animated animate__fadeInDown">Welcome to Ministerial Officers Portal</h1>
                <p class="animate__animated animate__fadeInUp">Department of Education, Government of Uttarakhand</p>
                <div class="d-flex gap-3">
                    @auth
                        <a href="{{ in_array(auth()->user()->role, ['state_admin', 'division_admin', 'district_admin']) ? route('admin.dashboard') : route('employee.dashboard') }}" class="btn btn-warning btn-lg px-4 fw-bold">Go to My Dashboard</a>
                        <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
                    @else
                        <a href="{{ route('seniority') }}" class="btn btn-warning btn-lg px-4 fw-bold">View Seniority List</a>
                        <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
                    @endauth
                </div>
            </div>
            <div class="hero-split-image" style="background-image: url('https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');"></div>
        </div>
    @endif
</div>

<!-- News Ticker -->
<div class="news-ticker">
    <div class="container d-flex">
        <div class="fw-bold pe-3" style="background: var(--uk-green); z-index: 2; position: relative;">LATEST NEWS:</div>
        <div class="ticker-wrapper flex-grow-1 overflow-hidden">
            <div class="ticker-content" style="white-space: nowrap;">
                @forelse($news as $item)
                    <span class="me-5 text-white">🚩 {{ $item->title }} ({{ \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') }})</span>
                @empty
                    <span class="me-5 text-white">🚩 Welcome to the Educational Ministerial Officers Portal, Uttarakhand. Stay tuned for latest updates.</span>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Birthday Slider -->
@if($today_birthdays && $today_birthdays->count() > 0)
<div class="birthday-section full-width-slider">
    <div id="birthdayCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @foreach($today_birthdays as $index => $birthday)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <div class="birthday-banner-slide" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), url('{{ $birthday->image_url }}'); background-size: cover; background-position: center 20%; height: 400px; position: relative; overflow: hidden;">
                        <div class="container h-100">
                            <div class="d-flex flex-column justify-content-center h-100 text-white animate__animated animate__fadeIn">
                                <div class="mb-2">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold shadow-sm">
                                        🎂 TODAY'S BIRTHDAY
                                    </span>
                                </div>
                                <h1 class="display-3 fw-bold mb-1" style="text-shadow: 2px 2px 15px rgba(0,0,0,0.5);">{{ $birthday->name }}</h1>
                                <p class="fs-4 mb-4 text-white-50 fw-light">{{ $birthday->designation }}</p>
                                <div>
                                    <a href="{{ route('birthdays') }}" class="btn btn-warning btn-lg px-5 py-3 fw-bold shadow">
                                        <i class="fas fa-gift me-2"></i> View All Celebrations
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($today_birthdays->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#birthdayCarousel" data-bs-slide="prev" style="z-index: 20;">
                <span class="carousel-control-prev-icon bg-primary rounded-circle p-2"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#birthdayCarousel" data-bs-slide="next" style="z-index: 20;">
                <span class="carousel-control-next-icon bg-primary rounded-circle p-2"></span>
            </button>
        @endif
    </div>
</div>

<style>
    .birthday-section.full-width-slider {
        margin-top: 0;
        border-bottom: 5px solid var(--uk-saffron);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .birthday-banner-slide {
        transition: background-position 10s ease-out;
    }
    .carousel-item.active .birthday-banner-slide {
        background-position: center 30%;
    }
</style>
@endif

<!-- Main Content -->
<div class="container my-5">
    <div class="row g-4">

        @auth
        <!-- Work Forms Grid -->
        <div class="col-md-12 mt-4">
            <h3 class="mb-4 fw-bold border-start border-4 border-primary ps-3">Work Forms</h3>
            <div class="portal-grid mb-5">
                @forelse($work_forms as $workType => $forms)
                <a href="{{ route('work-forms.by-type', urlencode($workType)) }}" class="portal-grid-item">
                    <div class="icon-wrapper">
                        @php
                            $icons = [
                                'Forms' => 'fa-file-alt',
                                'Pannat' => 'fa-clipboard-list',
                                'Income Tax' => 'fa-calculator',
                                'Pension Data' => 'fa-user-clock',
                                'Government Orders' => 'fa-file-contract',
                                'Promotion Orders' => 'fa-award',
                                'House Rent Allowance' => 'fa-home',
                                'Dearness Allowance Rent' => 'fa-money-bill-wave',
                                'General Provident Fund' => 'fa-piggy-bank',
                                'Transfer Orders' => 'fa-exchange-alt',
                                'Seniority' => 'fa-list-ol',
                                'Bulk List' => 'fa-list',
                                'Tutorials' => 'fa-graduation-cap',
                                'Ministerial Class' => 'fa-user-tie',
                                'GIS Rate' => 'fa-chart-line',
                                'Notification' => 'fa-bell',
                                'Appointment Orders' => 'fa-user-plus',
                                'Statutory Orders' => 'fa-gavel',
                                'Upgrade Letter Orders' => 'fa-level-up-alt'
                            ];
                            $icon = $icons[$workType] ?? 'fa-file';
                        @endphp
                        <i class="fas {{ $icon }} fa-2x text-primary"></i>
                    </div>
                    <div class="title-en">{{ $workType }}</div>
                    <div class="title-hi text-muted small">{{ $forms->count() }} {{ $forms->count() == 1 ? 'Document' : 'Documents' }}</div>
                </a>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Work forms are being updated. Please check back later.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endauth
    </div>

    <div class="row g-4 mt-2">
        <!-- About Brief -->
        <div class="col-md-12">
            <div class="p-4 bg-white rounded shadow-sm h-100 border-top border-4 border-primary">
                <h4 class="fw-bold mb-3 text-primary">एजुकेशनल मिनिस्ट्रीयल ऑफिसर्स एसोसिएशन उत्तराखण्ड</h4>
                <p class="mb-4">एजुकेशनल मिनिस्ट्रीयल ऑफिसर्स एसोसिएशन उत्तराखण्ड राज्य के शिक्षा विभाग के मिनिस्ट्रीयल कर्मचारियों के हितों और कल्याण के लिए समर्पित एक संगठन है। इसका उद्देश्य कर्मचारियों को एक मंच प्रदान करना और आधुनिक तकनीकी सुविधाओं से जोड़ना है।</p>
                
                <h5 class="fw-bold text-dark mb-3">Our Mission / हमारा मिशन</h5>
                <p class="mb-4">मिनिस्ट्रीयल कर्मचारियों को डिजिटल सेवाओं से जोड़कर कार्यप्रणाली को पारदर्शी और कुशल बनाना। यह वेबसाइट एक केंद्रीकृत सूचना केंद्र के रूप में कार्य करती है। उत्तराखण्ड शिक्षा विभाग के मिनिस्ट्रीयल कर्मचारियों के हित और कल्याण के लिए समर्पित संगठन।</p>

                <h5 class="fw-bold text-dark mb-3">Core Objectives / मुख्य उद्देश्य:</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> कर्मचारियों को तकनीकी और डिजिटल सुविधाएं देना</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> आवेदन पत्र, आदेश, शासनादेश ऑनलाइन उपलब्ध कराना</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> रिक्तियों और संपर्क विवरण पारदर्शी रूप से साझा करना</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> वित्तीय और कर सलाह सेवाएं देना</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> छात्रवृत्ति और स्कूल/कार्यालय जानकारी उपलब्ध कराना</li>
                </ul>
                <button class="btn btn-primary fw-bold mt-3 px-4">Read More <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>


    </div>

    <!-- Photo Gallery Section -->
    @if(isset($gallery_photos) && $gallery_photos->count() > 0)
    <div class="row g-4 mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h3 class="fw-bold border-start border-4 border-danger ps-3 mb-0">Photo Gallery</h3>
                <a href="{{ route('gallery') }}" class="btn btn-outline-danger btn-sm">View All Photos</a>
            </div>
            <div class="row g-3">
                @foreach($gallery_photos as $index => $photo)
                    <div class="col-md-3 col-6">
                        <div class="gallery-item-home position-relative overflow-hidden rounded shadow-sm h-100 cursor-pointer" onclick="openHomeLightbox({{ $index }})" data-src="{{ asset('uploads/gallery/' . $photo->image_path) }}" data-title="{{ $photo->title }}">
                            <div class="position-relative">
                                <img src="{{ asset('uploads/gallery/' . $photo->image_path) }}" class="img-fluid w-100" alt="{{ $photo->title }}" style="height: 180px; object-fit: cover; transition: transform 0.3s;">
                                <div class="gallery-home-overlay">
                                    <i class="fas fa-search-plus text-white fa-2x"></i>
                                </div>
                            </div>
                            <div class="position-absolute bottom-0 start-0 w-100 bg-dark bg-opacity-75 text-white p-2 small text-truncate z-1">
                                {{ $photo->title }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Home Lightbox Modal -->
    <div class="modal fade" id="homeLightboxModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    
                    <div class="text-center">
                        <img id="homeLightboxImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; object-fit: contain;">
                        <div class="mt-3 text-white">
                            <h5 id="homeLightboxTitle" class="fw-bold"></h5>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <button class="btn btn-link text-white position-absolute top-50 start-0 translate-middle-y fs-1 text-decoration-none" onclick="prevHomeImage()" style="left: -50px !important;">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-link text-white position-absolute top-50 end-0 translate-middle-y fs-1 text-decoration-none" onclick="nextHomeImage()" style="right: -50px !important;">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .gallery-item-home {
            cursor: pointer;
        }
        .gallery-item-home img {
            transition: transform 0.3s ease;
        }
        .gallery-item-home:hover img {
            transform: scale(1.05);
        }
        .gallery-home-overlay {
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
            z-index: 2;
        }
        .gallery-item-home:hover .gallery-home-overlay {
            opacity: 1;
        }
        #homeLightboxModal .modal-xl {
            max-width: 90%;
        }
    </style>

    @push('scripts')
    <script>
        let homeCurrentIndex = 0;
        const homeGalleryItems = [];
        let homeLightboxModal;

        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('homeLightboxModal');
            if (modalElement) {
                homeLightboxModal = new bootstrap.Modal(modalElement);
                
                // Populate gallery items array
                document.querySelectorAll('.gallery-item-home').forEach((item, index) => {
                    homeGalleryItems.push({
                        src: item.getAttribute('data-src'),
                        title: item.getAttribute('data-title')
                    });
                });

                // Keyboard Navigation
                document.addEventListener('keydown', function(e) {
                    if (!modalElement.classList.contains('show')) return;
                    if (e.key === 'ArrowLeft') prevHomeImage();
                    if (e.key === 'ArrowRight') nextHomeImage();
                });
            }
        });

        function openHomeLightbox(index) {
            homeCurrentIndex = index;
            updateHomeLightbox();
            homeLightboxModal.show();
        }

        function updateHomeLightbox() {
            const item = homeGalleryItems[homeCurrentIndex];
            document.getElementById('homeLightboxImage').src = item.src;
            document.getElementById('homeLightboxTitle').textContent = item.title;
        }

        function nextHomeImage() {
            homeCurrentIndex = (homeCurrentIndex + 1) % homeGalleryItems.length;
            updateHomeLightbox();
        }

        function prevHomeImage() {
            homeCurrentIndex = (homeCurrentIndex - 1 + homeGalleryItems.length) % homeGalleryItems.length;
            updateHomeLightbox();
        }
    </script>
    @endpush
    @endif
</div>

<!-- News Popup Modal -->
@if(isset($popup_news) && $popup_news)
<div class="modal fade" id="newsPopupModal" tabindex="-1" aria-labelledby="newsPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold" id="newsPopupLabel">
                    <i class="fas fa-bell me-2"></i> Latest Update
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if($popup_news->image)
                    <img src="{{ asset('uploads/news/' . $popup_news->image) }}" class="img-fluid w-100" alt="{{ $popup_news->title }}" style="max-height: 400px; object-fit: cover;">
                @endif
                <div class="p-4">
                    <h4 class="fw-bold mb-3">{{ $popup_news->title }}</h4>
                    <div class="text-muted mb-3 small">
                        <i class="far fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($popup_news->publish_date)->format('d M, Y') }}
                    </div>
                    <div class="news-content">
                        {!! Str::limit(strip_tags($popup_news->content), 300) !!}
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light justify-content-center">
                <a href="{{ route('orders') }}" class="btn btn-outline-danger fw-bold rounded-pill px-4">View All Updates</a>
                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var newsModal = new bootstrap.Modal(document.getElementById('newsPopupModal'));
        newsModal.show();
    });
</script>
@endif

@endsection
