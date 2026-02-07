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
                            <div class="breadcrumb-slider">
                                <a href="{{ url('/') }}">Forside</a>
                                <span class="separator">></span>
                                <span>International</span>
                            </div>
                            
                            <h1 class="animate__animated animate__fadeInDown">{{ $slide->title }}</h1>
                            <p class="animate__animated animate__fadeInUp">{{ $slide->subtitle }}</p>
                            
                            <div class="d-flex gap-3 animate__animated animate__zoomIn">
                                @if($slide->link)
                                    <a href="{{ $slide->link }}" class="btn btn-warning btn-lg px-4 fw-bold">Read More</a>
                                @else
                                    <a href="{{ route('seniority') }}" class="btn btn-warning btn-lg px-4 fw-bold">View Seniority List</a>
                                    <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
                                @endif
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
                <div class="breadcrumb-slider">
                    <a href="{{ url('/') }}">Home</a>
                    <span class="separator">></span>
                    <span>Welcome</span>
                </div>
                <h1 class="animate__animated animate__fadeInDown">Welcome to Ministerial Officers Portal</h1>
                <p class="animate__animated animate__fadeInUp">Department of Education, Government of Uttarakhand</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('seniority') }}" class="btn btn-warning btn-lg px-4 fw-bold">View Seniority List</a>
                    <a href="{{ route('orders') }}" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
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
        <div class="ticker-content flex-grow-1 overflow-hidden" style="white-space: nowrap;">
            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                @forelse($news as $item)
                    <span class="me-5 text-white">🚩 {{ $item->title }} ({{ \Carbon\Carbon::parse($item->publish_date)->format('d-m-Y') }})</span>
                @empty
                    <span class="me-5 text-white">🚩 Welcome to the Educational Ministerial Officers Portal, Uttarakhand. Stay tuned for latest updates.</span>
                @endforelse
            </marquee>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container my-5">
    <div class="row g-4">
        <!-- Portal Forms Grid -->
        <div class="col-md-12">
            <h3 class="mb-4 fw-bold border-start border-4 border-warning ps-3">Important Downloads & Links</h3>
            <div class="portal-grid mb-5">
                @forelse($portal_forms as $form)
                <a href="{{ $form->file_path ? asset('uploads/portal/forms/' . $form->file_path) : ($form->external_url ?? '#') }}" class="portal-grid-item" {{ $form->external_url ? 'target="_blank"' : '' }}>
                    <div class="icon-wrapper">
                        @if($form->icon)
                            <img src="{{ asset('uploads/portal/icons/' . $form->icon) }}" alt="{{ $form->title }}">
                        @else
                            <i class="fas fa-file-alt fa-2x text-muted"></i>
                        @endif
                    </div>
                    <div class="title-en">{{ $form->title }}</div>
                    @if($form->hindi_title)
                        <div class="title-hi">{{ $form->hindi_title }}</div>
                    @endif
                </a>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Portal content is being updated. Please check back later.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <!-- About Brief -->
        <div class="col-md-8">
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

        <!-- Sidebar Notice Board -->
        <div class="col-md-4">
            <div class="notice-board h-100">
                <h4 class="fw-bold mb-4 text-center border-bottom pb-2">Latest Updates</h4>
                @php
                    $regular_news = \App\Models\News::where('is_published', true)->latest()->take(6)->get();
                @endphp
                @forelse($regular_news as $notice)
                    <div class="notice-item p-2 border-bottom">
                        @if($notice->created_at->diffInDays() < 3)
                            <span class="badge bg-danger mb-1">New</span>
                        @endif
                        <h6 class="mb-1 fw-bold" style="font-size: 0.9rem;">{{ $notice->title }}</h6>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-calendar-alt me-1"></i> {{ $notice->publish_date }}</span>
                            @if($notice->image)
                                <a href="{{ asset('storage/' . $notice->image) }}" target="_blank" class="small text-primary text-decoration-none">View Image</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <p class="text-muted small">No active notices at the moment.</p>
                    </div>
                @endforelse
                <div class="mt-4 text-center">
                    <a href="{{ route('orders') }}" class="btn btn-dark btn-sm px-4">View All Archive</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
