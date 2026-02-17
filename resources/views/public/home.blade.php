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



<!-- Birthday Slider Section -->
@if(isset($today_birthdays) && $today_birthdays->count() > 0)
<div class="birthday-section position-relative py-5">
    <div class="container">
        <div class="birthday-card-wrapper mx-auto position-relative">
            <!-- Decorative Background Elements -->
            <div class="confetti-bg"></div>
            
            <!-- Carousel -->
            <div id="birthdayCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    @foreach($today_birthdays as $index => $birthday)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-0 align-items-center justify-content-center p-md-4 p-3">
                            <!-- Photo Section -->
                            <div class="col-md-5 text-center mb-4 mb-md-0 position-relative z-2">
                                <div class="birthday-photo-frame mx-auto">
                                    <div class="photo-bg"></div>
                                    <img src="{{ $birthday->image_url }}" alt="{{ $birthday->name }}" class="birthday-img">
                                    <div class="birthday-date-badge">
                                        {{ $birthday->dob->format('d F') }}
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="col-md-7 position-relative z-2">
                                <div class="birthday-message-box bg-white p-4 rounded-4 shadow-sm position-relative">
                                    <!-- Speech Bubble Arrow -->
                                    <div class="speech-arrow d-none d-md-block"></div>
                                    
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="fs-4 me-2">🎉</span>
                                        <h5 class="fw-bold text-secondary mb-0">This Month's Celebrations!</h5>
                                        <span class="fs-4 ms-2">🎂</span>
                                    </div>
                                    
                                    <h2 class="birthday-name-title mb-3">
                                        Happy Birthday <span class="text-primary">{{ $birthday->name }}</span>! 🎈
                                    </h2>
                                    
                                    <p class="birthday-text text-muted mb-3">
                                        The Educational Ministerial Officers Association, Uttarakhand extends best wishes to you on your special day. May your birthday be filled with love, happiness, and success. Enjoy your wonderful day to the fullest! 🥳
                                    </p>
                                    
                                    <div class="d-flex align-items-center justify-content-between mt-4 border-top pt-3">
                                        <div>
                                            <h4 class="text-primary fw-bold mb-0" style="font-family: 'Playfair Display', serif;">Wish You a Wonderful Day!</h4>
                                            <small class="text-muted fw-bold">{{ $birthday->designation }}</small>
                                        </div>
                                        <i class="fas fa-gift fa-3x text-warning opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($today_birthdays->count() > 1)
                <button class="carousel-control-prev birthday-nav-btn" type="button" data-bs-target="#birthdayCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-white rounded-circle shadow-sm p-3 text-dark" style="background-image: none; display: flex; align-items: center; justify-content: center;" aria-hidden="true">
                        <i class="fas fa-chevron-left text-primary"></i>
                    </span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next birthday-nav-btn" type="button" data-bs-target="#birthdayCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-white rounded-circle shadow-sm p-3 text-dark" style="background-image: none; display: flex; align-items: center; justify-content: center;" aria-hidden="true">
                        <i class="fas fa-chevron-right text-primary"></i>
                    </span>
                    <span class="visually-hidden">Next</span>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

@endif

<!-- Main Content -->
<div class="container my-5">
    <div class="row g-4">

        <!-- Work Forms Section -->
        <div class="col-md-12 mt-4">
            <h3 class="mb-4 fw-bold border-start border-4 border-primary ps-3">Work Forms</h3>
            
            @auth
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
            @else
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center mb-5 bg-light">
                <div class="mb-4">
                    <i class="fas fa-lock fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="fw-bold mb-3">Employee Access Only</h4>
                <p class="text-muted mb-4 mx-auto" style="max-width: 500px;">
                    Departmental work forms, templates, and administrative documents are restricted to registered employees only. Please login with your credentials to view and download these forms.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('employee.login') }}" class="btn btn-primary px-4 fw-bold">
                        <i class="fas fa-sign-in-alt me-2"></i> Login to View
                    </a>
                    <a href="{{ route('employee.register') }}" class="btn btn-outline-primary px-4 fw-bold">
                        <i class="fas fa-user-plus me-2"></i> Register Now
                    </a>
                </div>
            </div>
            @endauth
        </div>
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
                @foreach($gallery_photos as $photo)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden gallery-card cursor-pointer" 
                            onclick="openHomeLightbox({{ $photo->id }})"
                            data-id="{{ $photo->id }}"
                            data-src="{{ asset('uploads/gallery/' . $photo->image_path) }}" 
                            data-title="{{ $photo->title }}"
                            data-photos="{{ json_encode($photo->photos) }}">
                            <div class="gallery-item-home">
                                <img src="{{ asset('uploads/gallery/' . $photo->image_path) }}" class="card-img-top" alt="{{ $photo->title }}" style="height: 180px; object-fit: cover; transition: transform 0.3s;">
                                <div class="gallery-home-overlay">
                                    <i class="fas fa-search-plus text-white fa-2x"></i>
                                </div>
                            </div>
                            <div class="card-body p-2 text-center">
                                <h6 class="fw-bold mb-1 text-truncate" style="font-size: 0.9rem;">{{ $photo->title }}</h6>
                                <span class="badge bg-light text-primary border border-primary-subtle rounded-pill" style="font-size: 0.7rem;">{{ $photo->category }}</span>
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
        .gallery-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .gallery-item-home {
            position: relative;
            cursor: pointer;
            overflow: hidden;
        }
        .gallery-item-home img {
            transition: transform 0.3s ease;
        }
        .gallery-card:hover .gallery-item-home img {
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
        .gallery-card:hover .gallery-home-overlay {
            opacity: 1;
        }
        #homeLightboxModal .modal-xl {
            max-width: 90%;
        }
    </style>

    @push('scripts')
    <script>
        let homeCurrentAlbum = [];
        let homeCurrentPhotoIndex = 0;
        let homeLightboxModal;

        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('homeLightboxModal');
            if (modalElement) {
                homeLightboxModal = new bootstrap.Modal(modalElement);

                // Keyboard Navigation
                document.addEventListener('keydown', function(e) {
                    if (!modalElement.classList.contains('show')) return;
                    if (e.key === 'ArrowLeft') prevHomeImage();
                    if (e.key === 'ArrowRight') nextHomeImage();
                });
            }
        });

        function openHomeLightbox(galleryId) {
            const card = document.querySelector(`.gallery-card[data-id="${galleryId}"]`);
            const title = card.getAttribute('data-title');
            const mainSrc = card.getAttribute('data-src');
            
            // Get inner photos from the data attribute
            const innerPhotos = JSON.parse(card.getAttribute('data-photos'));
            
            // Build the album: Main photo + Inner photos
            homeCurrentAlbum = [
                { src: mainSrc, title: title }
            ];
            
            innerPhotos.forEach(photo => {
                homeCurrentAlbum.push({
                    src: "{{ asset('uploads/gallery') }}/" + photo.photo_path,
                    title: title
                });
            });

            homeCurrentPhotoIndex = 0;
            updateHomeLightbox();
            homeLightboxModal.show();

            // Show/Hide navigation based on album size
            const navBtns = document.querySelectorAll('#homeLightboxModal .btn-link');
            if (homeCurrentAlbum.length > 1) {
                navBtns.forEach(btn => btn.style.display = 'block');
            } else {
                navBtns.forEach(btn => btn.style.display = 'none');
            }
        }

        function updateHomeLightbox() {
            const item = homeCurrentAlbum[homeCurrentPhotoIndex];
            document.getElementById('homeLightboxImage').src = item.src;
            document.getElementById('homeLightboxTitle').textContent = item.title + (homeCurrentAlbum.length > 1 ? ` (${homeCurrentPhotoIndex + 1}/${homeCurrentAlbum.length})` : '');
        }

        function nextHomeImage() {
            if (homeCurrentAlbum.length <= 1) return;
            homeCurrentPhotoIndex = (homeCurrentPhotoIndex + 1) % homeCurrentAlbum.length;
            updateHomeLightbox();
        }

        function prevHomeImage() {
            if (homeCurrentAlbum.length <= 1) return;
            homeCurrentPhotoIndex = (homeCurrentPhotoIndex - 1 + homeCurrentAlbum.length) % homeCurrentAlbum.length;
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
                    <img src="{{ asset('uploads/news/' . $popup_news->image) }}" class="img-fluid w-100" alt="{{ $popup_news->title }}" style="object-fit: contain;">
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
