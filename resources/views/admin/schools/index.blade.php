@extends('layouts.admin')

@section('page_title', 'Manage Schools')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">District Schools</h5>
        <a href="{{ route('admin.schools.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add New School</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">School Name</th>
                        <th>UDISE Code</th>
                        <th>Block</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $school->name }}</div>
                            <small class="text-muted">{{ $school->address }}</small>
                        </td>
                        <td>{{ $school->udise_code ?? 'N/A' }}</td>
                        <td>{{ $school->block }}</td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucwords(str_replace('_', ' ', $school->type)) }}</span>
                        </td>
                        <td>
                            @if($school->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <a href="#" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-school fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No schools found in this district.</p>
                            <a href="{{ route('admin.schools.create') }}" class="btn btn-sm btn-primary">Add First School</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $schools->links() }}
    </div>
</div>
@endsection
