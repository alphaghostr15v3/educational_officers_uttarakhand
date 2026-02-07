@extends('layouts.admin')

@section('page_title', 'System Notifications')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Recent Announcements</h5>
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New Notification</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Title</th>
                        <th>Target Role</th>
                        <th>Type</th>
                        <th>Created By</th>
                        <th>Date</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notif)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $notif->title }}</div>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 300px;">{{ Str::limit($notif->message, 100) }}</small>
                        </td>
                        <td>
                            @if($notif->target_role)
                                <span class="badge bg-secondary">{{ $notif->target_role }}</span>
                            @elseif($notif->user_id)
                                <span class="badge bg-dark text-white">Specific User</span>
                            @else
                                <span class="badge bg-light text-dark border">All Users</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $notif->type }} opacity-75">{{ ucfirst($notif->type) }}</span>
                        </td>
                        <td>
                            <small class="fw-bold">{{ $notif->creator->name ?? 'System' }}</small>
                        </td>
                        <td>{{ $notif->created_at->format('d M, Y') }}</td>
                        <td class="text-end px-4">
                            <form action="{{ route('admin.notifications.destroy', $notif) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this notification?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No notifications sent yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
