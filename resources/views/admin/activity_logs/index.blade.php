@extends('layouts.admin')

@section('page_title', 'System Activity Logs')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0 text-dark">Audit Trail (Last 30 Days)</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Timestamp</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th class="text-end pe-4">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="ps-4 small">{{ $log->created_at->format('d M y, H:i:s') }}</td>
                        <td>
                            <div class="fw-bold small">{{ $log->user->name }}</div>
                            <span class="badge {{ $log->user->role == 'state_admin' ? 'bg-dark' : 'bg-secondary' }} small" style="font-size: 0.6rem;">{{ strtoupper($log->user->role) }}</span>
                        </td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ strtoupper($log->action) }}</span></td>
                        <td><p class="small mb-0 text-muted">{{ $log->description }}</p></td>
                        <td class="text-end pe-4 small text-muted">{{ $log->ip_address }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted small">No activity recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $logs->links() }}
    </div>
</div>
@endsection
