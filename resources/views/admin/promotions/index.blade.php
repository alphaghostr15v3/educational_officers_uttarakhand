@extends('layouts.admin')

@section('page_title', 'Promotion Approvals')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Promotion Orders</h5>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Grant Promotion</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($promotions as $promo)
                    <tr>
                        <td class="px-4">
                            <div class="fw-bold">{{ $promo->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">Order: {{ $promo->order_number ?? '-' }}</small>
                        </td>
                        <td>{{ $promo->current_designation }}</td>
                        <td><strong class="text-primary">{{ $promo->promoted_designation }}</strong></td>
                        <td>{{ $promo->promotion_date ? $promo->promotion_date->format('d M, Y') : '-' }}</td>
                        <td>
                            @if($promo->status === 'pending')
                                <span class="badge bg-secondary">Pending at District</span>
                            @elseif($promo->status === 'district_forwarded')
                                <span class="badge bg-info">Forwarded to Division</span>
                            @elseif($promo->status === 'division_recommended')
                                <span class="badge bg-warning text-dark">Recommended to State</span>
                            @elseif($promo->status === 'approved')
                                <span class="badge bg-success">Approved & Updated</span>
                            @elseif($promo->status === 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="d-flex justify-content-end gap-1">
                                @if($promo->file_path)
                                    <a href="{{ asset('uploads/promotions/'.$promo->file_path) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Order File"><i class="fas fa-file-pdf"></i></a>
                                @endif

                                @php $role = auth()->user()->role; @endphp

                                {{-- District Admin Actions --}}
                                @if($role === 'district_admin' && $promo->status === 'pending')
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="forward">
                                        <button type="submit" class="btn btn-sm btn-info text-white" title="Forward to Division" onclick="return confirm('Forward to Division?')"><i class="fas fa-arrow-right"></i></button>
                                    </form>
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject" onclick="return confirm('Reject this promotion?')"><i class="fas fa-times"></i></button>
                                    </form>
                                @endif

                                {{-- Division Admin Actions --}}
                                @if($role === 'division_admin' && $promo->status === 'district_forwarded')
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="recommend">
                                        <button type="submit" class="btn btn-sm btn-warning text-dark" title="Recommend to State" onclick="return confirm('Recommend to State?')"><i class="fas fa-thumbs-up"></i></button>
                                    </form>
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject" onclick="return confirm('Reject this promotion?')"><i class="fas fa-times"></i></button>
                                    </form>
                                @endif

                                {{-- State Admin Actions --}}
                                @if($role === 'state_admin' && $promo->status === 'division_recommended')
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="approve">
                                        <button type="submit" class="btn btn-sm btn-success" title="Approve & Finalize" onclick="return confirm('Approve and update employee designation?')"><i class="fas fa-check"></i> Approve</button>
                                    </form>
                                    <form action="{{ route('admin.promotions.status.update', $promo) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Reject" onclick="return confirm('Reject this promotion?')"><i class="fas fa-times"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <p class="text-muted">No promotion records found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $promotions->links() }}
    </div>
</div>
@endsection
