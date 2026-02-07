@extends('layouts.admin')

@section('page_title', 'Election Duty Management')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Election Duty Assignments</h5>
        <a href="{{ route('admin.election-duties.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Assign New Duty</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee</th>
                        <th>Election Name</th>
                        <th>Duty Type</th>
                        <th>Location</th>
                        <th>Period</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($duties as $duty)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $duty->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $duty->user->district->name ?? 'Unknown' }} - {{ $duty->user->school->name ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $duty->election_name }}</td>
                        <td><span class="badge bg-light text-dark border">{{ $duty->duty_type }}</span></td>
                        <td>{{ $duty->location ?? '-' }}</td>
                        <td>
                            <small>
                                {{ $duty->from_date->format('d M, Y') }} 
                                @if($duty->to_date)
                                    - {{ $duty->to_date->format('d M, Y') }}
                                @endif
                            </small>
                        </td>
                        <td>
                            @if($duty->status === 'assigned')
                                <span class="badge bg-primary">Assigned</span>
                            @elseif($duty->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-danger">Exempted</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex justify-content-end gap-1">
                                <a href="{{ route('admin.election-duties.edit', $duty) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.election-duties.destroy', $duty) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <p class="text-muted">No election duty assignments found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $duties->links() }}
    </div>
</div>
@endsection
