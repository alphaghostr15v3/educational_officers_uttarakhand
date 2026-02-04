@extends('layouts.frontend_admin')

@section('admin_title', 'Content Manager Overview')

@section('frontend_admin_content')
<div class="row g-4 text-center">
    <div class="col-md-6">
        <div class="p-5 bg-white border rounded shadow-sm h-100 transition-hover">
            <i class="fas fa-images fa-4x text-primary mb-4 opacity-75"></i>
            <h5 class="fw-bold">Hero Slider</h5>
            <p class="text-muted small mb-4">Manage the large professional photos and calls-to-action on the homepage.</p>
            <a href="{{ route('admin.frontend.slider') }}" class="btn btn-primary px-4 fw-bold">Manage Slides</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-5 bg-white border rounded shadow-sm h-100 transition-hover">
            <i class="fas fa-th fa-4x text-warning mb-4 opacity-75"></i>
            <h5 class="fw-bold">Home Grid</h5>
            <p class="text-muted small mb-4">Update the colorful quick-link buttons for forms and external portals.</p>
            <a href="{{ route('admin.portal-forms.index') }}" class="btn btn-warning px-4 fw-bold">Manage Icons</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-5 bg-white border rounded shadow-sm h-100 transition-hover">
            <i class="fas fa-newspaper fa-4x text-info mb-4 opacity-75"></i>
            <h5 class="fw-bold">News Ticker</h5>
            <p class="text-muted small mb-4">Update the scrolling news announcements on the public homepage.</p>
            <a href="{{ route('admin.news.index') }}" class="btn btn-info px-4 fw-bold text-white">Manage News</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="p-5 bg-white border rounded shadow-sm h-100 transition-hover">
            <i class="fas fa-list-ol fa-4x text-success mb-4 opacity-75"></i>
            <h5 class="fw-bold">Seniority Lists</h5>
            <p class="text-muted small mb-4">Upload and organize CADRE records for the public directory.</p>
            <a href="{{ route('admin.seniority.index') }}" class="btn btn-success px-4 fw-bold">Manage Lists</a>
        </div>
    </div>
</div>

<style>
.transition-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.transition-hover:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
}
</style>
@endsection
