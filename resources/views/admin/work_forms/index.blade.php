@extends('layouts.admin')

@section('page_title', 'Edit / Upload Works')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0"><i class="fas fa-folder-open me-2"></i>Work Forms Management</h6>
        <a href="{{ route('admin.work-forms.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-upload me-1"></i> Upload New Work
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 60px;">S.NO</th>
                        <th>WORK TYPE</th>
                        <th>SUB-CATEGORY</th>
                        <th>TITLE</th>
                        <th>UPLOADED BY</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th class="text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workForms as $index => $workForm)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            <span class="badge bg-primary-subtle text-primary">{{ $workForm->work_type }}</span>
                        </td>
                        <td>
                            @if($workForm->sub_category)
                                <span class="badge bg-info-subtle text-info">{{ $workForm->sub_category }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold small">{{ $workForm->title }}</div>
                        </td>
                        <td>
                            <small class="text-muted">{{ $workForm->uploader->name ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <small class="text-muted">{{ $workForm->created_at->format('d M, Y') }}</small>
                        </td>
                        <td>
                            @if($workForm->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ asset('storage/' . $workForm->file_path) }}" target="_blank" class="btn btn-light text-info" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('admin.work-forms.edit', $workForm) }}" class="btn btn-light text-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.work-forms.destroy', $workForm) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this work form?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light text-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                            <h6>No work forms uploaded yet.</h6>
                            <p class="small">Start by uploading your first work document.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
