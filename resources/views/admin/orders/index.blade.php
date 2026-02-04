@extends('layouts.admin')

@section('page_title', 'Departmental Orders')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Order Repository</h6>
        <a href="{{ route('admin.orders.create') }}" class="btn btn-success btn-sm px-3">
            <i class="fas fa-upload me-1"></i> Upload New Order
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No / Date</th>
                        <th>Subject Title</th>
                        <th>Jurisdiction</th>
                        <th>Category</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold small text-primary">{{ $order->order_number }}</div>
                            <div class="text-muted small">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</div>
                        </td>
                        <td>
                            <div class="fw-bold small">{{ $order->title }}</div>
                            <div class="text-muted small text-truncate" style="max-width: 250px;">{{ $order->description }}</div>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary small text-uppercase" style="font-size: 0.65rem;">{{ $order->level }}</span>
                            @if($order->division) <div class="small text-muted" style="font-size: 0.7rem;">{{ $order->division->name }}</div> @endif
                            @if($order->district) <div class="small text-muted" style="font-size: 0.7rem;">{{ $order->district->name }}</div> @endif
                        </td>
                        <td>
                            <span class="badge {{ $order->category == 'transfer' ? 'bg-info' : ($order->category == 'promotion' ? 'bg-success' : ($order->category == 'govt_order' ? 'bg-primary' : 'bg-warning')) }} small">
                                {{ ucfirst($order->category) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ asset('uploads/orders/' . $order->file_path) }}" target="_blank" class="btn btn-outline-danger btn-sm me-2" title="View PDF">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this order?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No departmental orders found in your jurisdiction.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
