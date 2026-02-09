@extends('layouts.admin')

@section('page_title', 'View Inquiry')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('admin.contacts.index') }}" class="btn btn-link text-decoration-none p-0 text-muted">
        <i class="fas fa-arrow-left me-1"></i> Back to Inquiries
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-primary">Message Details</h6>
                <span class="badge {{ $contact->is_read ? 'bg-light text-muted border' : 'bg-danger' }} rounded-pill px-3">
                    {{ $contact->is_read ? 'READ' : 'NEW MESSAGE' }}
                </span>
            </div>
            <div class="card-body p-4">
                <div class="mb-4 pb-4 border-bottom">
                    <h5 class="fw-bold mb-1">{{ $contact->subject }}</h5>
                    <div class="text-muted small">Received: {{ $contact->created_at->format('l, d F Y, h:i A') }} ({{ $contact->created_at->diffForHumans() }})</div>
                </div>

                <div class="message-content" style="white-space: pre-wrap; line-height: 1.6; font-size: 1.05rem; color: #374151;">
                    {{ $contact->message }}
                </div>
            </div>
            <div class="card-footer bg-light py-3">
                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm px-4 fw-bold">
                        <i class="fas fa-trash me-2"></i> Delete Inquiry
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-dark">Sender Information</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($contact->full_name) }}&background=f3f4f6&color=374151&bold=true" class="rounded-circle me-3" style="width: 50px;">
                    <div>
                        <div class="fw-bold">{{ $contact->full_name }}</div>
                        <a href="mailto:{{ $contact->email }}" class="small text-primary text-decoration-none d-block">{{ $contact->email }}</a>
                        @if($contact->mobile_number)
                            <div class="small text-muted mt-1"><i class="fas fa-phone-alt me-1"></i> {{ $contact->mobile_number }}</div>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary fw-bold">
                        <i class="fas fa-reply me-2"></i> Reply via Email
                    </a>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info border-0 shadow-sm">
            <h6 class="fw-bold mb-2"><i class="fas fa-lightbulb me-2"></i> Tip</h6>
            <p class="small mb-0">Replies are currently handled via your default email client. We'll be adding an in-portal reply feature in future updates.</p>
        </div>
    </div>
</div>
@endsection
