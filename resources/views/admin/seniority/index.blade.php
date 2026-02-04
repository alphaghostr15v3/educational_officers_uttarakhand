@extends('layouts.admin')

@section('page_title', 'Manage Seniority Lists')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Cadre Seniority Records</h6>
        <a href="{{ route('admin.seniority.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-file-upload me-1"></i> Upload List
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Year</th>
                        <th>Seniority List Title</th>
                        <th>Cadre/Category</th>
                        <th>Uploaded By</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lists as $list)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">{{ $list->year }}</td>
                        <td class="small fw-bold">{{ $list->title }}</td>
                        <td><span class="badge bg-secondary small" style="font-size: 0.6rem;">{{ strtoupper($list->cadre) }}</span></td>
                        <td><small class="text-muted">{{ $list->uploadedBy->name }}</small></td>
                        <td class="text-end pe-4">
                             <a href="{{ asset('uploads/seniority/' . $list->file_path) }}" target="_blank" class="btn btn-light btn-sm text-danger"><i class="fas fa-file-pdf"></i></a>
                            <form action="{{ route('admin.seniority.destroy', $list) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-sm text-muted"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted small">No seniority lists found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
