@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-0 fw-bold">My Leave Applications</h1>
            <p class="text-muted">Track your leave requests and their approval status.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2"></i> Apply for Leave
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4">#</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th>Total Days</th>
                            <th>Status</th>
                            <th class="text-end px-4">Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $leave)
                        @php
                            $start = \Carbon\Carbon::parse($leave->start_date);
                            $end = \Carbon\Carbon::parse($leave->end_date);
                            $days = $start->diffInDays($end) + 1;
                        @endphp
                        <tr>
                            <td class="px-4">{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">{{ $leave->type }}</span></td>
                            <td>{{ $start->format('d M, Y') }} - {{ $end->format('d M, Y') }}</td>
                            <td>{{ $days }} Day(s)</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $leave->status == 'approved' ? 'success' : ($leave->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                            <td class="text-end px-4">{{ $leave->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-times mb-2 fa-2x"></i><br>
                                No leave applications found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
