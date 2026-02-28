@extends('layouts.employee')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Help & Support Requests</h4>
            <p class="text-muted small">Track your queries sent to various administrative levels</p>
        </div>
        <a href="{{ route('employee.help.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>New Help Request
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Target Level</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr>
                                <td class="ps-4">
                                    <div class="small fw-bold">{{ $request->created_at->format('d M, Y') }}</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">{{ $request->created_at->format('h:i A') }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary text-uppercase" style="font-size: 0.7rem;">
                                        {{ $request->target_level }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-bold small">{{ $request->subject }}</div>
                                </td>
                                <td>
                                    @if($request->status == 'pending')
                                        <span class="badge bg-warning-subtle text-warning">Pending</span>
                                    @elseif($request->status == 'resolved')
                                        <span class="badge bg-success-subtle text-success">Resolved</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Closed</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#viewRequest{{ $request->id }}">
                                        <i class="fas fa-eye me-1"></i>View
                                    </button>
                                </td>
                            </tr>

                            <!-- View Modal -->
                            <div class="modal fade" id="viewRequest{{ $request->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header border-bottom p-4">
                                            <h5 class="modal-title fw-bold">Request Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="mb-4">
                                                <label class="text-muted small text-uppercase fw-bold d-block mb-1">Subject</label>
                                                <div class="h5 fw-bold">{{ $request->subject }}</div>
                                            </div>
                                            <div class="mb-4">
                                                <label class="text-muted small text-uppercase fw-bold d-block mb-1">Original Message</label>
                                                <div class="bg-light p-3 rounded" style="white-space: pre-wrap;">{{ $request->message }}</div>
                                            </div>
                                            
                                            @if($request->admin_reply)
                                                <div class="mb-0">
                                                    <label class="text-primary small text-uppercase fw-bold d-block mb-1">Admin Response</label>
                                                    <div class="bg-primary bg-opacity-10 p-3 rounded border border-primary border-opacity-25" style="white-space: pre-wrap;">{{ $request->admin_reply }}</div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer border-top p-3">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-question-circle fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-0">No help requests found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($requests->hasPages())
            <div class="card-footer bg-white border-top p-3">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
