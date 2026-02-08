@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-0 fw-bold">Notices & Circulars</h1>
            <p class="text-muted">Stay updated with the latest government orders and department circulars.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">Date</th>
                            <th>Circular No</th>
                            <th>Title</th>
                            <th>Level</th>
                            <th class="text-end px-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($circulars as $circular)
                        <tr>
                            <td class="px-4 text-muted small">
                                {{ \Carbon\Carbon::parse($circular->circular_date)->format('d M, Y') }}
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal">{{ $circular->circular_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $circular->title }}</div>
                                @if($circular->is_new)
                                    <span class="badge bg-danger rounded-pill" style="font-size: 0.7rem;">New</span>
                                @endif
                                @if($circular->description)
                                    <div class="small text-muted text-truncate" style="max-width: 300px;">{{ $circular->description }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                    {{ ucfirst($circular->level) }}
                                </span>
                            </td>
                            <td class="text-end px-4">
                                <a href="{{ asset('uploads/circulars/' . $circular->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="fas fa-download me-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-bullhorn fa-3x mb-3 opacity-25"></i>
                                <p>No circulars found matching your criteria.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($circulars->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $circulars->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
