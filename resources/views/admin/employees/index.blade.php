@extends('layouts.admin')

@section('page_title', 'Employee List')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Employees in Jurisdiction</h5>
        <div>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-dark btn-sm px-3 fw-bold">
                <i class="fas fa-user-plus me-1"></i> Add Employee
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee Name</th>
                        <th>Employee Code</th>
                        <th>Designation</th>
                        <th>Current School</th>
                        <th>Mobile</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $employee->image_url }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold">{{ $employee->name }}</div>
                                    <small class="text-muted">{{ $employee->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark fw-normal border">{{ $employee->employee_code ?? 'N/A' }}</span></td>
                        <td>{{ $employee->designation }}</td>
                        <td>{{ $employee->staff->school->name ?? 'N/A' }}</td>
                        <td>{{ $employee->mobile ?? 'N/A' }}</td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-light text-success" title="View Profile">
                                <i class="fas fa-id-card me-1"></i> View Profile
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="fas fa-user-slash fa-3x"></i>
                            </div>
                            <h5>No employees found</h5>
                            <p class="text-muted">There are no employee accounts registered in your area yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($employees->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $employees->links() }}
    </div>
    @endif
</div>
@endsection
