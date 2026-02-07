@extends('layouts.admin')

@section('page_title', 'Leave Approvals')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Leave Requests</h5>
        <a href="{{ route('admin.leaves.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Record Leave</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $leave->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">ID: {{ $leave->user_id }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $leave->type }}</span></td>
                        <td>
                            {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M, Y') }}
                            <br>
                            <small class="text-muted">({{ $leave->start_date->diffInDays($leave->end_date) + 1 }} days)</small>
                        </td>
                        <td>{{ Str::limit($leave->reason, 30) }}</td>
                        <td>
                            @if($leave->status === 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($leave->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            @if($leave->status === 'pending')
                            <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn-sm btn-success" title="Approve"><i class="fas fa-check"></i></button>
                            </form>
                            <form action="{{ route('admin.leaves.update', $leave->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="rejected">
                                <button class="btn btn-sm btn-danger" title="Reject"><i class="fas fa-times"></i></button>
                            </form>
                            @else
                                <button class="btn btn-sm btn-light border" disabled>Processed</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="text-muted">No leave records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $leaves->links() }}
    </div>
</div>
@endsection
