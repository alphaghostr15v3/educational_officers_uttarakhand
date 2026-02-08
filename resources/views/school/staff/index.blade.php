@extends('layouts.school')

@section('title', 'Staff Details')

@section('school_content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Staff Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('school.staff.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Add New Staff
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Joining Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffs as $staff)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $staff->user->name ?? 'N/A' }}</td>
                            <td>{{ $staff->designation }}</td>
                            <td>{{ $staff->user->mobile ?? 'N/A' }}</td>
                            <td>{{ $staff->user->email ?? 'N/A' }}</td>
                            <td>{{ $staff->joining_date ? \Carbon\Carbon::parse($staff->joining_date)->format('d M Y') : '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $staff->current_status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($staff->current_status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('school.staff.edit', $staff->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('school.staff.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this staff record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No staff members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $staffs->links() }}
        </div>
    </div>
</div>
@endsection
