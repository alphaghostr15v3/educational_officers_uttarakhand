@extends('layouts.admin')

@section('page_title', 'Vacancy Overview')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">School Vacancy Status</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">School Name</th>
                        <th>District</th>
                        <th>Sanctioned Posts</th>
                        <th>Filled</th>
                        <th>Vacant</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schools as $school)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $school->name }}</div>
                            <small class="text-muted">{{ $school->block }}</small>
                        </td>
                        <td>{{ $school->district->name ?? 'N/A' }}</td>
                        <td>{{ $school->sanctioned_posts }}</td>
                        <td>{{ $school->staffs_count }}</td>
                        <td>
                            <strong class="{{ $school->vacancy > 5 ? 'text-danger' : 'text-primary' }}">
                                {{ $school->vacancy }}
                            </strong>
                        </td>
                        <td>
                            @if($school->vacancy > 5)
                                <span class="badge bg-danger">Critical</span>
                            @elseif($school->vacancy > 0)
                                <span class="badge bg-warning text-dark">Open</span>
                            @else
                                <span class="badge bg-success">Full</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No vacancy data available.</p>
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
