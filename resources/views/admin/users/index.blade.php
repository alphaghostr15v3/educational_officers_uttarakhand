@extends('layouts.admin')

@section('page_title', 'System User Management')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Portal Administrators</h6>
        <a href="{{ route('admin.users.create') }}" class="btn btn-dark btn-sm px-3">
            <i class="fas fa-user-plus me-1"></i> Add Admin
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Admin Name</th>
                        <th>Email & Role</th>
                        <th>Jurisdiction</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name={{ $user->name }}&background=334155&color=fff" class="rounded-circle me-2" style="width: 32px;">
                                <div class="fw-bold small">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold">{{ $user->email }}</div>
                            <span class="badge {{ $user->role == 'state_admin' ? 'badge-state' : ($user->role == 'division_admin' ? 'badge-division' : 'badge-district') }} small" style="font-size: 0.6rem;">
                                {{ strtoupper(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>
                        <td>
                            @if($user->role == 'state_admin')
                                <span class="text-muted small">Uttarakhand (All)</span>
                            @elseif($user->role == 'division_admin')
                                <span class="small fw-bold text-dark">{{ $user->division->name ?? 'N/A' }}</span>
                            @else
                                <div class="small fw-bold text-dark">{{ $user->district->name ?? 'N/A' }}</div>
                                <div class="text-muted small" style="font-size: 0.7rem;">{{ $user->division->name ?? '' }}</div>
                            @endif
                        </td>
                        <td><span class="badge bg-success-subtle text-success small">Active</span></td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">No other administrative users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
