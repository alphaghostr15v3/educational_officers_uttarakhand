@extends('layouts.admin')

@section('page_title', 'Donation Records')

@section('admin_content')
<div class="card table-card mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="fw-bold mb-0">Donation Filter</h6>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">District</label>
                <select name="district_id" class="form-select">
                    <option value="">All Districts</option>
                    @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Payment Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary px-4 fw-bold w-100">Apply Filters</button>
            </div>
        </form>
    </div>
</div>

<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Welfare Contributions</h6>
        <button class="btn btn-outline-success btn-sm"><i class="fas fa-file-excel me-1"></i> Export Excel</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Receipt No</th>
                        <th>Donor Name</th>
                        <th>District</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                    <tr>
                        <td class="ps-4">
                            <span class="text-primary fw-bold">{{ $donation->receipt_number }}</span>
                            <div class="small text-muted">{{ $donation->created_at->format('d M, Y') }}</div>
                        </td>
                        <td>
                            <div class="fw-bold small">{{ $donation->donor_name }}</div>
                            <div class="text-muted small">{{ $donation->mobile }}</div>
                        </td>
                        <td><span class="small">{{ $donation->district->name }}</span></td>
                        <td><span class="fw-bold">₹ {{ number_format($donation->amount, 2) }}</span></td>
                        <td>
                            <span class="badge {{ $donation->payment_status == 'completed' ? 'bg-success' : ($donation->payment_status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }} small px-3">
                                {{ ucfirst($donation->payment_status) }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-light btn-sm text-primary" title="Download Receipt"><i class="fas fa-download"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-hand-holding-usd fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">No donation records found.</h6>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        {{ $donations->links() }}
    </div>
</div>
@endsection
