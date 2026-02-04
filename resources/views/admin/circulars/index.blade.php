@extends('layouts.admin')

@section('page_title', 'Department Circulars')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Circular Repository</h6>
        <a href="{{ route('admin.circulars.create') }}" class="btn btn-dark btn-sm">
            <i class="fas fa-file-upload me-1"></i> Upload Circular
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No. & Date</th>
                        <th>Circular Title</th>
                        <th>Jurisdiction</th>
                        <th>Uploaded By</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($circulars as $circular)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold small text-primary">{{ $circular->circular_number }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ $circular->circular_date }}</div>
                        </td>
                        <td class="fw-bold small">{{ $circular->title }}</td>
                        <td>
                            <span class="badge {{ $circular->level == 'state' ? 'bg-dark' : 'bg-info' }} small" style="font-size: 0.6rem;">{{ strtoupper($circular->level) }}</span>
                            @if($circular->division) <div class="small text-muted" style="font-size: 0.7rem;">{{ $circular->division->name }}</div> @endif
                        </td>
                        <td><small class="text-muted">{{ $circular->uploadedBy->name }}</small></td>
                        <td class="text-end pe-4">
                            <a href="{{ asset('storage/' . $circular->file_path) }}" target="_blank" class="btn btn-light btn-sm text-danger"><i class="fas fa-file-pdf"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted small">No circulars found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
