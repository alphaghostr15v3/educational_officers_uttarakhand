@extends('layouts.employee')

@section('content')
<div class="container-fluid text-dark">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 mb-0 fw-bold">My Transfer Applications</h1>
            <p class="text-muted">History of your transfer requests and current status.</p>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('employee.transfers.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-exchange-alt me-2"></i> Apply for Transfer
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
                            <th>Current School</th>
                            <th>Desired School</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th class="text-end px-4">Applied On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transfers as $transfer)
                        <tr>
                            <td class="px-4">{{ $loop->iteration }}</td>
                            <td>{{ $transfer->fromSchool->name ?? 'Initial Listing' }}</td>
                            <td><span class="fw-bold">{{ $transfer->toSchool->name ?? 'N/A' }}</span></td>
                            <td>{{ Str::limit($transfer->reason, 30) }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $transfer->status == 'approved' ? 'success' : ($transfer->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($transfer->status) }}
                                </span>
                            </td>
                            <td class="text-end px-4">{{ $transfer->created_at->format('d M, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-shipping-fast mb-2 fa-2x"></i><br>
                                No transfer applications found.
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
