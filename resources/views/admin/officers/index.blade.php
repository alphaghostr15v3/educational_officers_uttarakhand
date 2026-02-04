@extends('layouts.admin')

@section('page_title', 'Manage Officers')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Officer List</h6>
        <a href="{{ route('admin.officers.create') }}" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-plus me-1"></i> Add New Officer
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Employee Code</th>
                        <th>Name & Designation</th>
                        <th>District / Division</th>
                        <th>Contact</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($officers as $officer)
                    <tr>
                        <td class="ps-4 fw-bold text-primary">{{ $officer->employee_code }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $officer->photo ? asset('uploads/officers/' . $officer->photo) : 'https://ui-avatars.com/api/?name=' . $officer->name }}" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                <div>
                                    <div class="fw-bold small">{{ $officer->name }}</div>
                                    <div class="text-muted" style="font-size: 0.75rem;">{{ $officer->designation }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold">{{ $officer->district->name }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ $officer->division->name }}</div>
                        </td>
                        <td>
                            <div class="small"><i class="fas fa-envelope me-1 text-muted"></i> {{ $officer->email ?? 'N/A' }}</div>
                            <div class="small"><i class="fas fa-phone me-1 text-muted"></i> {{ $officer->mobile ?? 'N/A' }}</div>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><a class="dropdown-item" href="{{ route('admin.officers.edit', $officer) }}"><i class="fas fa-edit me-2 text-info"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.officers.destroy', $officer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this officer?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fas fa-trash-alt me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No officers found in your administrative scope.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $officers->links() }}
    </div>
</div>
@endsection
