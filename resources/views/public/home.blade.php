@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title mb-3">Welcome to Ministerial Officers Portal</h1>
        <p class="lead mb-4 fw-bold">Department of Education, Government of Uttarakhand</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#" class="btn btn-warning btn-lg px-4 fw-bold">View Seniority List</a>
            <a href="#" class="btn btn-light btn-lg px-4 fw-bold border-2">Departmental Orders</a>
        </div>
    </div>
</section>

<!-- News Ticker -->
<div class="news-ticker">
    <div class="container d-flex">
        <div class="fw-bold pe-3" style="background: var(--uk-green); z-index: 2; position: relative;">LATEST NEWS:</div>
        <div class="ticker-content flex-grow-1">
            @forelse($news as $item)
                <span class="me-5">🚩 {{ $item->title }}</span>
            @empty
                <span class="me-5">🚩 Welcome to the Educational Ministerial Officers Portal, Uttarakhand.</span>
            @endforelse
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
                <a href="{{ $form->file_path ? asset('storage/' . $form->file_path) : ($form->external_url ?? '#') }}" class="portal-grid-item" {{ $form->external_url ? 'target="_blank"' : '' }}>
                    <div class="icon-wrapper">
                        @if($form->icon)
                            <img src="{{ asset('storage/' . $form->icon) }}" alt="{{ $form->title }}">
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
                <h4 class="fw-bold mb-4 text-center border-bottom pb-2">Notice Board</h4>
                <div class="notice-item">
                    <span class="badge bg-danger mb-1">New</span>
                    <p class="mb-1 small">Submission of data for upcoming state level elections ends on Friday.</p>
                    <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-calendar-alt me-1"></i> Oct 24, 2024</span>
                </div>
                <div class="notice-item">
                    <p class="mb-1 small">Mandatory verification of employee code for all district officers.</p>
                    <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-calendar-alt me-1"></i> Oct 22, 2024</span>
                </div>
                <div class="notice-item">
                    <p class="mb-1 small">Holiday List for 2025 has been uploaded in circulars.</p>
                    <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-calendar-alt me-1"></i> Oct 20, 2024</span>
                </div>
                <div class="notice-item">
                    <p class="mb-1 small">Guidelines for online donation submission through the portal.</p>
                    <span class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-calendar-alt me-1"></i> Oct 18, 2024</span>
                </div>
                <div class="mt-4 text-center">
                    <a href="#" class="btn btn-dark btn-sm px-4">View All Notices</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
