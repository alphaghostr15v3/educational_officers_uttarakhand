@extends('layouts.admin')

@section('page_title', 'Manage Staff')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">District Staff</h5>
        <div>
            <a href="{{ route('admin.staff.export') }}" class="btn btn-outline-success btn-sm me-2"><i class="fas fa-file-csv"></i> Export CSV</a>
            <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New Staff</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Name</th>
                        <th>Designation</th>
                        <th>School</th>
                        <th>Joining Date</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $staff->user->name ?? 'Unknown' }}</div>
                            <small class="text-muted">{{ $staff->user->email ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $staff->designation }}</td>
                        <td>{{ $staff->school->name ?? 'N/A' }}</td>
                        <td>{{ $staff->joining_date ? $staff->joining_date->format('d M, Y') : '-' }}</td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($staff->current_status) }}</span>
                        </td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-sm btn-light text-success me-1" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-light text-primary me-1" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this staff member? This will also delete their login account.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No staff found in this district.</p>
                            <a href="{{ route('admin.staff.create') }}" class="btn btn-sm btn-primary">Add First Staff</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $staffs->links() }}
    </div>
</div>
@endsection
