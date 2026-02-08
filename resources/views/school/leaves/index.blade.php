@extends('layouts.school')

@section('page_title', 'Leave Applications')

@section('school_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-check me-2 text-primary"></i>Leave Applications</h5>
        <a href="{{ route('school.leaves.create') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Apply New Leave
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Period</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaves as $leave)
                    <tr>
                        <td>#{{ $leave->id }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucfirst($leave->type) }}</span>
                        </td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($leave->start_date)->format('d M, Y') }}</div>
                            <div class="small text-muted">to {{ \Carbon\Carbon::parse($leave->end_date)->format('d M, Y') }}</div>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $leave->reason }}">
                                {{ $leave->reason }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger'
                                ][$leave->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td>{{ $leave->created_at->format('d M, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-alt fa-3x mb-3 opacity-25"></i>
                            <p>No leave applications found.</p>
                            <a href="{{ route('school.leaves.create') }}" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Apply Now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $leaves->links() }}
        </div>
    </div>
</div>
@endsection
