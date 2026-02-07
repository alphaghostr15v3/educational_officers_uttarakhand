@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-0 fw-bold">My Notifications</h1>
            <p class="text-muted">Stay informed with system alerts and personal messages.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">Date</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                        <tr class="{{ !$notification->is_read ? 'bg-light border-start border-primary border-4' : '' }}">
                            <td class="px-4 text-muted small">
                                {{ $notification->created_at->format('d M, Y H:i') }}
                            </td>
                            <td>
                                <div class="fw-bold">{{ $notification->title }}</div>
                            </td>
                            <td>
                                <div class="text-wrap" style="max-width: 500px;">{{ $notification->message }}</div>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($notification->type) {
                                        'alert' => 'danger',
                                        'update' => 'info',
                                        'event' => 'success',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }} bg-opacity-10 text-{{ $badgeClass }} border border-{{ $badgeClass }} border-opacity-25">
                                    {{ ucfirst($notification->type) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-bell-slash fa-3x mb-3 opacity-25"></i>
                                <p>No notifications found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($notifications->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
