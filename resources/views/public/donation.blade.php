@extends('layouts.public')

@section('content')
<div class="bg-warning text-white py-5 mb-5 shadow-sm">
    <div class="container text-center text-dark">
        <h1 class="fw-bold">Welfare & Donation</h1>
        <p class="lead mb-0 fw-bold">Support the Ministerial Officers Association's welfare programs.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-5">
        <!-- Donation Form -->
        <div class="col-md-7">
            <div class="bg-white p-4 p-md-5 rounded shadow-sm border-top border-5 border-warning">
                <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success fw-bold">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
                <form action="{{ route('donation.process') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Full Name</label>
                            <input type="text" name="donor_name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">District</label>
                            <select name="district_id" class="form-select" required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Donation Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" class="form-control form-control-lg" name="amount" placeholder="500" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Purpose of Donation</label>
                            <textarea class="form-control" name="purpose" rows="3" placeholder="e.g. Welfare Fund, Event support..."></textarea>
                        </div>
                        <div class="col-md-12 pt-3">
                            <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold text-uppercase py-3">
                                Proceed to Payment <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Welfare Info -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-success-subtle d-inline-flex p-3 mb-3">
                        <i class="fas fa-hand-holding-heart fa-3x text-success"></i>
                    </div>
                    <h4 class="fw-bold">Why Donate?</h4>
                    <p class="text-muted small">Your contributions help us support officers in times of medical emergencies, disaster relief, and organizing educational workshops for skill enhancement.</p>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm bg-dark text-white p-4">
                <h5 class="fw-bold border-bottom border-warning pb-2 mb-3">Transparency Policy</h5>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Instant receipt generation.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Secure SSL encrypted payments.</li>
                    <li class="mb-3"><i class="fas fa-check-circle text-warning me-2"></i> Real-time tracking of funds.</li>
                    <li><i class="fas fa-check-circle text-warning me-2"></i> Audited by state welfare committee.</li>
                </ul>
            </div>
            
            <div class="mt-4 text-center">
                <img src="https://images.unsplash.com/photo-1593642532400-2682810df593?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" class="img-fluid rounded shadow-sm" alt="Transparency">
            </div>
        </div>
    </div>
</div>
@endsection
