@extends('layouts.admin')

@section('page_title', 'Voting Portal')

@section('admin_content')
<div class="row g-4">
    @forelse($elections as $election)
    <div class="col-md-6">
        <div class="card stat-card shadow-sm border-0 border-top border-4 border-primary h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-primary">{{ $election->title }}</h5>
                        <span class="badge bg-primary-subtle text-primary small text-uppercase" style="font-size: 0.6rem;">{{ $election->level }} Level</span>
                    </div>
                </div>
                <p class="text-muted small mb-4">{{ Str::limit($election->description, 120) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <div class="small text-muted"> <i class="fas fa-clock me-1"></i> Ends: {{ \Carbon\Carbon::parse($election->end_date)->format('d M, Y') }}</div>
                    <a href="{{ route('admin.elections.vote.show', $election) }}" class="btn btn-primary fw-bold px-4">Cast Vote</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="bg-white p-5 rounded shadow-sm">
            <i class="fas fa-vote-yea fa-4x text-muted mb-3"></i>
            <h5 class="text-muted">No active elections found for your region at this time.</h5>
        </div>
    </div>
    @endforelse
</div>
@endsection
