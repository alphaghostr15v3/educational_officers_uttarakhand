@extends('layouts.admin')

@section('page_title', 'Cast Your Vote')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">{{ $election->title }}</h2>
            <p class="text-muted">Please select your preferred candidate. Your vote is anonymous and final.</p>
        </div>

        <form action="{{ route('admin.elections.vote.cast', $election) }}" method="POST">
            @csrf
            <div class="row g-4">
                @foreach($election->candidates as $candidate)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm transition-hover overflow-hidden">
                        <div class="card-body p-4 text-center">
                            <div class="mx-auto bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-user-tie fa-3x text-primary"></i>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $candidate->officer->name }}</h4>
                            <div class="badge bg-secondary mb-3">{{ $candidate->officer->designation }}</div>
                            <p class="small text-muted mb-4">{{ $candidate->manifesto ?? 'Committed to officer welfare and administrative excellence.' }}</p>
                            
                            <label class="btn btn-outline-primary w-100 fw-bold py-2">
                                <input type="radio" name="candidate_id" value="{{ $candidate->id }}" class="btn-check" autocomplete="off" required>
                                <span><i class="fas fa-check me-2 d-none"></i> Select Candidate</span>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5 pt-4 border-top">
                <button type="submit" class="btn btn-danger btn-lg px-5 fw-bold shadow" onclick="return confirm('Note: Once cast, your vote cannot be changed. Are you sure?')">
                    CONFIRM & SUBMIT BALLOT <i class="fas fa-paper-plane ms-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-check:checked + span::before {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        margin-right: 8px;
    }
    .btn-check:checked + span {
        background-color: var(--bs-primary);
        color: white;
    }
    .card:has(.btn-check:checked) {
        border: 2px solid var(--bs-primary) !important;
        background-color: var(--bs-primary-bg-subtle) !important;
    }
</style>
@endsection
