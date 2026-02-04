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
            <span class="me-5">🚩 Promotion list for Senior Assistant 2024 has been released.</span>
            <span class="me-5">🚩 Revised seniority list of Clerical Cadre published.</span>
            <span class="me-5">🚩 Important notice regarding General Election 2024 and Ministerial voting.</span>
            <span class="me-5">🚩 New transfer policy for ministerial officers updated.</span>
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
                <h4 class="fw-bold mb-3">About the Portal</h4>
                <p>This dedicated portal serves as the central hub for all Ministerial Officers under the Department of Education, Uttarakhand. It facilitates transparent data management, timely dissemination of orders, and automated seniority tracking. Our mission is to digitize all ministerial operations to ensure efficiency and ease of access for every officer across the state.</p>
                <button class="btn btn-outline-primary fw-bold mt-3">Read More <i class="fas fa-arrow-right ms-2"></i></button>
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
