@extends('layouts.admin')

@section('page_title', 'Help & Support Requests')

@section('admin_content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Employee</th>
                        <th>Region</th>
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
                                <div class="text-muted small">{{ $request->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="fw-bold small">{{ $request->employee->name }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $request->employee->employee_code }}</div>
                            </td>
                            <td>
                                <span class="badge bg-info-subtle text-info text-uppercase" style="font-size: 0.65rem;">
                                    @if($request->target_level == 'state')
                                        State Level
                                    @elseif($request->target_level == 'division')
                                        Division: {{ $request->targetDivision->name ?? 'N/A' }}
                                    @elseif($request->target_level == 'district')
                                        District: {{ $request->targetDistrict->name ?? 'N/A' }}
                                    @else
                                        Block: {{ $request->targetBlock->name ?? 'N/A' }}
                                    @endif
                                </span>
                            </td>
                            <td>{{ $request->subject }}</td>
                            <td>
                                @if($request->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($request->status == 'resolved')
                                    <span class="badge bg-success">Resolved</span>
                                @else
                                    <span class="badge bg-secondary">Closed</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#replyModal{{ $request->id }}">
                                    <i class="fas fa-reply me-1"></i>Reply
                                </button>
                            </td>
                        </tr>

                        <!-- Reply Modal -->
                        <div class="modal fade" id="replyModal{{ $request->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content border-0">
                                    <form action="{{ route('admin.help-requests.status.update', $request->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-primary text-white p-4">
                                            <h5 class="modal-title fw-bold">Manage Help Request</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="row mb-4">
                                                <div class="col-md-6">
                                                    <label class="text-muted small text-uppercase fw-bold">From Employee</label>
                                                    <p class="fw-bold mb-0">{{ $request->employee->name }} ({{ $request->employee->employee_code }})</p>
                                                    <p class="small text-muted">{{ $request->employee->email }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="text-muted small text-uppercase fw-bold">Subject</label>
                                                    <p class="fw-bold">{{ $request->subject }}</p>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="text-muted small text-uppercase fw-bold">Employee Message</label>
                                                <div class="bg-light p-3 rounded small">{{ $request->message }}</div>
                                            </div>

                                            <hr>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Your Response</label>
                                                <textarea name="admin_reply" class="form-control" rows="4" placeholder="Write your response here...">{{ $request->admin_reply }}</textarea>
                                            </div>

                                            <div class="mb-0">
                                                <label class="form-label fw-bold">Update Status</label>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusP{{ $request->id }}" value="pending" {{ $request->status == 'pending' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="statusP{{ $request->id }}">Pending</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusR{{ $request->id }}" value="resolved" {{ $request->status == 'resolved' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-success fw-bold" for="statusR{{ $request->id }}">Resolved</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="status" id="statusC{{ $request->id }}" value="closed" {{ $request->status == 'closed' ? 'checked' : '' }}>
                                                        <label class="form-check-label text-muted" for="statusC{{ $request->id }}">Closed</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-top p-3">
                                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                <p class="mb-0">No help requests for your region.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($requests->hasPages())
        <div class="card-footer bg-white p-3">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection
