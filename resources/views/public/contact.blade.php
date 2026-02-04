@extends('layouts.public')

@section('content')
<div class="container my-5">
    <div class="row g-5">
        <!-- Contact Info -->
        <div class="col-md-5">
            <h2 class="fw-bold text-primary mb-4">Get in Touch</h2>
            <p class="text-muted mb-5">Have any queries or suggestions? Reach out to our regional or state administrative offices across Uttarakhand.</p>
            
            <div class="d-flex mb-4">
                <div class="me-3">
                    <div class="rounded-circle bg-primary-subtle p-3 text-primary">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Main Headquarters</h5>
                    <p class="small text-muted mb-0">Directorate of Education, Nanur Khera, Raipur, Dehradun, Uttarakhand - 248001</p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="me-3">
                    <div class="rounded-circle bg-success-subtle p-3 text-success">
                        <i class="fas fa-phone-alt fa-lg"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Helpline Number</h5>
                    <p class="small text-muted mb-0">+91-135-271XXXX / 271YYYY</p>
                </div>
            </div>

            <div class="d-flex mb-5">
                <div class="me-3">
                    <div class="rounded-circle bg-info-subtle p-3 text-info">
                        <i class="fas fa-envelope fa-lg"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Email Correspondence</h5>
                    <p class="small text-muted mb-0">support-officers@uk.gov.in</p>
                </div>
            </div>

            <!-- Google Map Placeholder -->
            <div class="rounded shadow-sm overflow-hidden" style="height: 250px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110191.03668102641!2d78.006240!3d30.334149!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390929c3561660bd%3A0xef49870535e6cbf!2sDirectorate%20Of%20Education%20Uttarakhand!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-md-7">
            <div class="bg-white p-4 p-md-5 rounded shadow-sm border">
                <h3 class="fw-bold mb-4">Send us a Message</h3>
                <form action="#" method="POST">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Full Name</label>
                            <input type="text" class="form-control" placeholder="John Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Email Address</label>
                            <input type="email" class="form-control" placeholder="john@example.com" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted">Subject</label>
                            <select class="form-select">
                                <option>Data Correction</option>
                                <option>Promotion Inquiry</option>
                                <option>Transfer Request Query</option>
                                <option>Other General Enquiry</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-muted">Message</label>
                            <textarea class="form-control" rows="5" placeholder="How can we help you?"></textarea>
                        </div>
                        <div class="col-md-12 pt-3">
                            <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Send Message <i class="fas fa-paper-plane ms-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
