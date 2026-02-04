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
            <div class="bg-white p-4 p-md-5 shadow-sm rounded-3" style="border-top: 5px solid #ffc107;">
                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-success fw-bold mb-4">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('donation.process') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Full Name</label>
                                <input type="text" name="donor_name" class="form-control form-control-lg border-light-subtle rounded-2" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control form-control-lg border-light-subtle rounded-2" placeholder="Enter mobile number" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">District</label>
                                <select name="district_id" class="form-select form-select-lg border-light-subtle rounded-2 text-muted" required style="font-size: 0.95rem;">
                                    <option value="">Select District</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Donation Amount (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-light-subtle fw-bold">₹</span>
                                    <input type="number" class="form-control form-control-lg border-light-subtle" name="amount" placeholder="500" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Purpose of Donation</label>
                                <textarea class="form-control border-light-subtle rounded-2" name="purpose" rows="4" placeholder="e.g. Welfare Fund, Event support..."></textarea>
                            </div>
                            <div class="col-md-12 pt-2">
                                <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold border-0 py-3 shadow-sm rounded-2" style="background-color: #ffc107; color: #000; letter-spacing: 1px;">
                                    PROCEED TO PAYMENT <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Welfare Info -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm mb-4 rounded-4">
                <div class="card-body p-4 text-center">
                    <div class="rounded-circle bg-success-subtle d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px;">
                        <i class="fas fa-hand-holding-heart fa-3x text-success"></i>
                    </div>
                    <h2 class="fw-bold mb-3">Why Donate?</h2>
                    <p class="text-muted px-3" style="font-size: 0.95rem; line-height: 1.6;">Your contributions help us support officers in times of medical emergencies, disaster relief, and organizing educational workshops for skill enhancement.</p>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm bg-dark text-white p-4 rounded-4 mb-4">
                <h3 class="fw-bold mb-0">Transparency Policy</h3>
                <hr class="border-warning border-2 opacity-100 my-3" style="width: 100%;">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i> Instant receipt generation.</li>
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i> Secure SSL encrypted payments.</li>
                    <li class="mb-3 d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i> Real-time tracking of funds.</li>
                    <li class="d-flex align-items-center"><i class="fas fa-check-circle text-warning me-3 fs-5"></i> Audited by state welfare committee.</li>
                </ul>
            </div>
            
            <div class="rounded-4 overflow-hidden shadow-sm">
                <img src="{{ asset('images/donation_workspace.png') }}" class="img-fluid" alt="Support & Progress">
            </div>
        </div>
    </div>
</div>
@endsection
