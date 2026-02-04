@extends('layouts.public')

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Sidebar Navigation -->
        <div class="col-md-3">
            <div class="list-group shadow-sm">
                <a href="#history" class="list-group-item list-group-item-action active bg-primary border-primary">Department History</a>
                <a href="#mission" class="list-group-item list-group-item-action">Mission & Vision</a>
                <a href="#structure" class="list-group-item list-group-item-action">Organizational Structure</a>
            </div>
            
            <div class="mt-4 p-3 bg-white rounded shadow-sm">
                <h6 class="fw-bold text-uppercase border-bottom pb-2">Director's Message</h6>
                <div class="text-center my-3">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&h=150&q=80" class="rounded-circle img-fluid border border-3 border-warning" alt="Director">
                </div>
                <p class="small text-muted mb-0">"Our commitment to excellence in ministerial administration defines the core of our educational infrastructure."</p>
                <div class="mt-2 fw-bold small">- Director of Education</div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-md-9">
            <div class="bg-white p-5 rounded shadow-sm">
                <h2 id="history" class="fw-bold mb-4 border-bottom pb-2 text-primary">About Department</h2>
                <p>The Department of Education in Uttarakhand has a long-standing tradition of academic and administrative excellence. Since the formation of the state in 2000, the ministerial cadre has played a pivotal role in maintaining the logistical and administrative backbone of our educational institutions.</p>
                
                <h4 id="mission" class="fw-bold mt-5 mb-3 text-success">Mission & Vision</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-light p-3">
                            <h5 class="fw-bold"><i class="fas fa-bullseye text-danger me-2"></i>Mission</h5>
                            <p class="small mb-0">To ensure seamless administrative support to the educational sector through efficient management of ministerial staff data, promotions, and welfare.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100 border-0 bg-light p-3">
                            <h5 class="fw-bold"><i class="fas fa-eye text-primary me-2"></i>Vision</h5>
                            <p class="small mb-0">A fully digitized and transparent administrative framework where every ministerial officer can access their records and departmental information instantly.</p>
                        </div>
                    </div>
                </div>

                <h4 id="structure" class="fw-bold mt-5 mb-3 text-secondary">Organizational Structure</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Designation</th>
                                <th>Role Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-bold text-primary">Directorate Level</td>
                                <td>Policy making and overall administration of ministerial cadre across Uttarakhand.</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">Division Level</td>
                                <td>Supervision of district operations and handling of divisional seniority lists.</td>
                            </tr>
                            <tr>
                                <td class="fw-bold text-primary">District Level</td>
                                <td>Execution of departmental orders and managing school-level administrative staff.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <p class="mt-4">The Educational Ministerial Officers Portal represents our latest step toward a "Digital Uttarakhand", empowering our workforce with tools for better governance and communication.</p>
            </div>
        </div>
    </div>
</div>
@endsection
