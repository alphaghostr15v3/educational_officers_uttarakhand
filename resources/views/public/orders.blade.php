@extends('layouts.public')

@section('content')
<div class="bg-primary text-white py-5 mb-5 shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold">Orders & Circulars</h1>
                <p class="lead mb-0">Browse latest departmental government orders, transfers, and notices.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search orders...">
                    <button class="btn btn-warning"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Categories -->
        <div class="col-md-3">
            <h5 class="fw-bold mb-3">Categories</h5>
            <div class="list-group shadow-sm mb-4">
                <a href="#" class="list-group-item list-group-item-action active">All Orders</a>
                <a href="#" class="list-group-item list-group-item-action">Transfer Orders</a>
                <a href="#" class="list-group-item list-group-item-action">Promotion Orders</a>
                <a href="#" class="list-group-item list-group-item-action">Govt. Orders (GO)</a>
                <a href="#" class="list-group-item list-group-item-action">General Notices</a>
            </div>
            
            <h5 class="fw-bold mb-3">Year Filter</h5>
            <div class="list-group shadow-sm">
                <a href="#" class="list-group-item list-group-item-action">2024</a>
                <a href="#" class="list-group-item list-group-item-action">2023</a>
                <a href="#" class="list-group-item list-group-item-action">Archive</a>
            </div>
        </div>

        <!-- Orders List -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Order Number / Date</th>
                                    <th>Title & Subject</th>
                                    <th>Category</th>
                                    <th class="text-center">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary">#UK-EDU-2024-88</div>
                                        <div class="small text-muted">Oct 24, 2024</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Inter-District Transfer List - Group C</div>
                                        <p class="small text-muted mb-0">Regarding transfer of ministerial officers in Garhwal division.</p>
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary">Transfer</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary">#UK-GO-1209</div>
                                        <div class="small text-muted">Oct 20, 2024</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Promotion Announcement: Senior Assistant to AO</div>
                                        <p class="small text-muted mb-0">List of eligible candidates for promotion to Administrative Officer.</p>
                                    </td>
                                    <td><span class="badge bg-success-subtle text-success">Promotion</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary">#DHE-CIRC-05</div>
                                        <div class="small text-muted">Oct 15, 2024</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">Mandatory Attendance Policy Update</div>
                                        <p class="small text-muted mb-0">Implementation of biometric attendance for all ministerial staff.</p>
                                    </td>
                                    <td><span class="badge bg-info-subtle text-info">General Notice</span></td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection
