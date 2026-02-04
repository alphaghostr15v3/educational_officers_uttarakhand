@extends('layouts.admin')

@section('page_title', 'Election Management')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Portal Elections</h6>
        <a href="{{ route('admin.elections.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-plus me-1"></i> Create New Election
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Title & Level</th>
                        <th>Schedule</th>
                        <th>Status</th>
                        <th>Candidates</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($elections as $election)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold small">{{ $election->title }}</div>
                            <span class="badge bg-secondary-subtle text-secondary small text-uppercase" style="font-size: 0.65rem;">{{ $election->level }}</span>
                            @if($election->division) <span class="small text-muted fw-bold">({{ $election->division->name }})</span> @endif
                        </td>
                        <td>
                            <div class="small fw-bold">{{ \Carbon\Carbon::parse($election->start_date)->format('d M, Y H:i') }}</div>
                            <div class="text-muted small">to {{ \Carbon\Carbon::parse($election->end_date)->format('d M, Y H:i') }}</div>
                        </td>
                        <td>
                            @php
                                $statusClass = match($election->status) {
                                    'active' => 'bg-success',
                                    'draft' => 'bg-warning text-dark',
                                    'completed' => 'bg-primary',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }} py-2 px-3">{{ ucfirst($election->status) }}</span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $election->candidates->count() }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.elections.show', $election) }}" class="btn btn-outline-primary btn-sm me-1" title="Manage Candidates">
                                <i class="fas fa-users-cog"></i>
                            </a>
                            @if($election->status === 'draft')
                                <form action="{{ route('admin.elections.activate', $election) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-success btn-sm me-1" title="Go Live"><i class="fas fa-play"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-vote-yea fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No elections found. Create one to begin.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
