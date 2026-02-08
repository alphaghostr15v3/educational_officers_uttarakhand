@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('work-forms') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i> Back to All Work Forms
        </a>
        <h2 class="fw-bold">{{ $workType }}</h2>
        <p class="text-muted">{{ $workForms->count() }} {{ $workForms->count() == 1 ? 'document' : 'documents' }} available</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">S.No</th>
                                    @if($workType == 'Government Orders')
                                        <th>Sub-Category</th>
                                    @endif
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th class="text-end pe-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workForms as $index => $workForm)
                                <tr>
                                    <td class="ps-4">{{ $index + 1 }}</td>
                                    @if($workType == 'Government Orders')
                                        <td>
                                            @if($workForm->sub_category)
                                                <span class="badge bg-info-subtle text-info">{{ $workForm->sub_category }}</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        <div class="fw-bold">{{ $workForm->title }}</div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $workForm->created_at->format('d M, Y') }}</small>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ asset('uploads/work_forms/' . $workForm->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $workType == 'Government Orders' ? '5' : '4' }}" class="text-center py-5 text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 d-block"></i>
                                        <h6>No documents available</h6>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Information</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-3">
                        <i class="fas fa-file-pdf text-danger me-2"></i> All documents are available in PDF format
                    </p>
                    <p class="small mb-3">
                        <i class="fas fa-download text-primary me-2"></i> Click the download button to save documents
                    </p>
                    <p class="small mb-0">
                        <i class="fas fa-clock text-warning me-2"></i> Documents are updated regularly
                    </p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i> Need Help?</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">For any queries or assistance, please contact:</p>
                    <p class="small mb-0">
                        <i class="fas fa-envelope text-primary me-2"></i> support@example.com
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
