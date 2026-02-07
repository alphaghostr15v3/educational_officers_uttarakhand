@extends('layouts.public')

@section('content')
<div class="bg-success text-white py-5 mb-5 shadow-sm">
    <div class="container">
        <h1 class="fw-bold">Seniority Lists</h1>
        <p class="lead mb-0">Official cadre-wise and year-wise seniority lists for Ministerial Officers.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4 text-center">
        <!-- Cadre Selection Cards -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                <h4 class="fw-bold">Chief Administrative Officer</h4>
                <p class="small text-muted">Lists for CAO cadre ministerial officers.</p>
                <div class="mt-auto">
                    <button class="btn btn-primary w-100 fw-bold">View Lists</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <i class="fas fa-user-cog fa-3x text-success mb-3"></i>
                <h4 class="fw-bold">Administrative Officer</h4>
                <p class="small text-muted">Lists for AO cadre ministerial officers.</p>
                <div class="mt-auto">
                    <button class="btn btn-success w-100 fw-bold">View Lists</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <i class="fas fa-users-cog fa-3x text-warning mb-3"></i>
                <h4 class="fw-bold">Senior Assistant</h4>
                <p class="small text-muted">Lists for SA cadre ministerial officers.</p>
                <div class="mt-auto">
                    <button class="btn btn-warning w-100 fw-bold">View Lists</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Lists Table -->
    <div class="mt-5 text-start">
        <h3 class="fw-bold mb-4 border-start border-4 border-success ps-3">Recently Published Lists</h3>
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-4">Year</th>
                                <th>List Title</th>
                                <th>Cadre</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lists as $list)
                            <tr>
                                <td class="ps-4 fw-bold text-success">{{ $list->year }}</td>
                                <td>{{ $list->title }}</td>
                                <td><span class="badge bg-success-subtle text-success">{{ $list->cadre }}</span></td>
                                <td class="text-center">
                                    <a href="{{ asset('uploads/seniority/' . $list->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger px-4 fw-bold">
                                        <i class="fas fa-file-pdf me-1"></i> View PDF
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-folder-5342750-4461327.png" alt="Empty" style="height: 120px;" class="mb-3 d-block mx-auto">
                                    <h6 class="text-muted">No seniority lists published yet.</h6>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
