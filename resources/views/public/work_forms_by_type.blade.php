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
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 60px;">S.No</th>
                                    @if($workType == 'Government Orders')
                                        <th>Sub-Category</th>
                                        <th>Promotion Details</th>
                                        <th>Revision Details</th>
                                    @elseif($workType == 'Promotion Orders')
                                        <th>Promotion Details</th>
                                    @endif
                                    <th>Title / Description</th>
                                    <th style="width: 120px;">Upload Date</th>
                                    <th class="text-end pe-4" style="width: 140px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workForms as $index => $workForm)
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                    @if($workType == 'Government Orders')
                                        <td>
                                            @if($workForm->sub_category)
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">{{ $workForm->sub_category }}</span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($workForm->promotion_order_number || $workForm->promotion_order_date)
                                                <div class="small fw-bold text-dark">No: {{ $workForm->promotion_order_number ?? '-' }}</div>
                                                <div class="small text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $workForm->promotion_order_date ? \Carbon\Carbon::parse($workForm->promotion_order_date)->format('d M, Y') : '-' }}</div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($workForm->dearness_percentage || $workForm->from_date || $workForm->go_year)
                                                @if($workForm->dearness_percentage)
                                                    <div class="small fw-bold text-success">Dearness: {{ $workForm->dearness_percentage }}%</div>
                                                @endif
                                                @if($workForm->from_date)
                                                    <div class="small text-muted text-nowrap"><i class="fas fa-clock me-1"></i>From: {{ \Carbon\Carbon::parse($workForm->from_date)->format('d M, Y') }}</div>
                                                @endif
                                                @if($workForm->go_year)
                                                    <div class="small fw-bold text-primary"><i class="fas fa-calendar-check me-1"></i>GO Year: {{ $workForm->go_year }}</div>
                                                @endif
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    @elseif($workType == 'Promotion Orders')
                                        <td>
                                            @if($workForm->promotion_order_number || $workForm->promotion_order_date)
                                                <div class="small fw-bold text-dark">No: {{ $workForm->promotion_order_number ?? '-' }}</div>
                                                <div class="small text-muted"><i class="far fa-calendar-alt me-1"></i>{{ $workForm->promotion_order_date ? \Carbon\Carbon::parse($workForm->promotion_order_date)->format('d M, Y') : '-' }}</div>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>
                                        <div class="fw-bold text-dark">{{ $workForm->title }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small text-nowrap">{{ $workForm->created_at->format('d M, Y') }}</div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="{{ asset('uploads/work_forms/' . $workForm->file_path) }}" target="_blank" class="btn btn-sm btn-primary px-3 shadow-sm">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $workType == 'Government Orders' ? '7' : ($workType == 'Promotion Orders' ? '5' : '4') }}" class="text-center py-5 text-muted">
                                        <div class="py-4">
                                            <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                            <h6 class="fw-bold">No documents available</h6>
                                            <p class="small mb-0">Records are being updated. Please check back later.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white py-3 border-0">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2"></i> Document Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-danger-subtle text-danger p-2 rounded-3 me-3">
                                    <i class="fas fa-file-pdf"></i>
                                </div>
                                <div class="small">All documents are available in high-quality PDF format for printing.</div>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary-subtle text-primary p-2 rounded-3 me-3">
                                    <i class="fas fa-download"></i>
                                </div>
                                <div class="small">Click the download button to save a copy to your device.</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="bg-warning-subtle text-warning p-2 rounded-3 me-3">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="small">Government orders and forms are updated regularly by administrative staff.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-secondary text-white py-3 border-0">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-question-circle me-2"></i> Assistance & Support</h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted mb-4">If you are unable to find a specific document or need technical assistance, please coordinate with the IT cell.</p>
                            <div class="d-flex align-items-center">
                                <div class="bg-dark text-white p-2 rounded-3 me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="small fw-bold">Email Support</div>
                                    <div class="small text-primary">support@example.com</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
