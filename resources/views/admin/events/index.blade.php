@extends('layouts.admin')

@section('page_title', 'Event Management')

@section('admin_content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-calendar-alt me-2 text-primary"></i> Event Management</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Event
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Event Date</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>
                            @if($event->image_path)
                                <img src="{{ asset('uploads/events/' . $event->image_path) }}" alt="{{ $event->title }}" style="width: 80px; height: 60px; object-fit: cover;" class="rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 60px;">
                                    <i class="fas fa-calendar-alt text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $event->title }}</strong>
                            @if($event->description)
                                <br><small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                            @endif
                        </td>
                        <td><small>{{ $event->event_date->format('M d, Y h:i A') }}</small></td>
                        <td><small class="text-muted">{{ $event->location ?? 'N/A' }}</small></td>
                        <td><span class="badge bg-info">{{ $event->category ?? 'General' }}</span></td>
                        <td>
                            <form action="{{ route('admin.events.toggle', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $event->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $event->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Delete this event permanently?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                <h5>No events added yet.</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
