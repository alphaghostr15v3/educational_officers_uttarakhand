@extends('layouts.admin')

@section('page_title', 'Transfer Approvals')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Transfer Requests</h5>
        <a href="{{ route('admin.transfers.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Initiate Transfer</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transfers as $transfer)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $transfer->user?->name ?? 'N/A' }}</div>
                            <small class="text-muted">ID: {{ $transfer->user_id }}</small>
                        </td>
                        <td>{{ $transfer->fromOffice?->name ?? '-' }}</td>
                        <td>{{ $transfer->toOffice?->name ?? '-' }}</td>
                        <td>{{ Str::limit($transfer->reason, 30) }}</td>
                        <td>
                            @if($transfer->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($transfer->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @elseif($transfer->status === 'pending')
                                <span class="badge bg-warning text-dark">Awaiting District</span>
                            @elseif($transfer->status === 'district_forwarded')
                                <span class="badge bg-info text-dark">Awaiting Division</span>
                            @elseif($transfer->status === 'division_recommended')
                                <span class="badge bg-primary">Awaiting State</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            @php
                                $user = auth()->user();
                                $canAction = false;
                                $actionName = '';
                                $actionValue = '';
                                
                                if ($user->role === 'district_admin' && $transfer->status === 'pending') {
                                    $canAction = true;
                                    $actionName = 'Forward to Division';
                                    $actionValue = 'forward';
                                } elseif ($user->role === 'division_admin' && $transfer->status === 'district_forwarded') {
                                    $canAction = true;
                                    $actionName = 'Recommend to State';
                                    $actionValue = 'recommend';
                                } elseif ($user->role === 'state_admin' && $transfer->status === 'division_recommended') {
                                    $canAction = true;
                                    $actionName = 'Final Approve';
                                    $actionValue = 'approve';
                                }
                            @endphp

                            @if($canAction)
                            <form action="{{ route('admin.transfers.status.update', $transfer->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="{{ $actionValue }}">
                                <button class="btn btn-sm btn-success" title="{{ $actionName }}">
                                    <i class="fas fa-arrow-right me-1"></i> {{ $actionName }}
                                </button>
                            </form>
                            <form action="{{ route('admin.transfers.status.update', $transfer->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button class="btn btn-sm btn-outline-danger" title="Reject"><i class="fas fa-times"></i></button>
                            </form>
                            @else
                                <span class="text-muted small">Processed / Awaiting Others</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="text-muted">No transfer requests found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $transfers->links() }}
    </div>
</div>
@endsection
