@extends('layouts.school')

@section('page_title', 'Transfer Applications')

@section('school_content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold"><i class="fas fa-exchange-alt me-2 text-primary"></i>Transfer Applications</h5>
        <a href="{{ route('school.transfers.create') }}" class="btn btn-primary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-plus me-1"></i> Apply New Transfer
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Target School</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transfers as $transfer)
                    <tr>
                        <td>#{{ $transfer->id }}</td>
                        <td>
                            <div class="fw-bold">{{ $transfer->user->name ?? 'N/A' }}</div>
                            <div class="small text-muted">{{ $transfer->user->designation ?? '' }}</div>
                        </td>
                        <td>{{ $transfer->toSchool->name ?? 'N/A' }}</td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $transfer->reason }}">
                                {{ $transfer->reason }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger'
                                ][$transfer->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill">
                                {{ ucfirst($transfer->status) }}
                            </span>
                        </td>
                        <td>{{ $transfer->created_at->format('d M, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-info-circle fa-3x mb-3 opacity-25"></i>
                            <p>No transfer applications found.</p>
                            <a href="{{ route('school.transfers.create') }}" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Apply Now</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $transfers->links() }}
        </div>
    </div>
</div>
@endsection
