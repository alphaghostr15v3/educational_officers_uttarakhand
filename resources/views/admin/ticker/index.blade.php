@extends('layouts.admin')

@section('page_title', 'News Ticker Management')

@section('admin_content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-rss me-2 text-success"></i> News Ticker</h4>
        <small class="text-muted">
            Manage scrolling news ticker on homepage
        </small>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.ticker.create') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Add Ticker Item
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4" width="60">Order</th>
                        <th>Ticker Text</th>
                        <th width="150">Publish Date</th>
                        <th width="100">Status</th>
                        <th class="text-end px-4" width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickers as $item)
                    <tr>
                        <td class="px-4 text-center">
                            <span class="badge bg-secondary">{{ $item->ticker_order ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-rss text-success me-2"></i>
                                <div>
                                    <div class="fw-bold">{{ $item->title }}</div>
                                    <small class="text-muted">By {{ $item->creator->name ?? 'Admin' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->publish_date)->format('d M, Y') }}</td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->is_published ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end px-4">
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" 
                                        class="btn btn-outline-{{ $item->is_published ? 'warning' : 'success' }} status-toggle-btn" 
                                        data-ticker-id="{{ $item->id }}"
                                        title="{{ $item->is_published ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas fa-{{ $item->is_published ? 'pause' : 'play' }}"></i>
                                </button>
                                <a href="{{ route('admin.ticker.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.ticker.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this ticker item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-rss fa-3x mb-3"></i>
                            <h5>No ticker items found.</h5>
                            <p>Create your first ticker item to display on the homepage.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($tickers->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $tickers->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Status toggle functionality
    document.querySelectorAll('.status-toggle-btn').forEach(button => {
        button.addEventListener('click', function() {
            const tickerId = this.dataset.tickerId;
            const btn = this;
            const originalHtml = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            fetch(`{{ url('admin/ticker') }}/${tickerId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button appearance
                    btn.classList.toggle('btn-outline-success');
                    btn.classList.toggle('btn-outline-warning');
                    btn.title = data.is_published ? 'Deactivate' : 'Activate';
                    btn.innerHTML = `<i class="fas fa-${data.is_published ? 'pause' : 'play'}"></i>`;
                    
                    // Update badge in the row
                    const row = btn.closest('tr');
                    const badgeCell = row.querySelector('td:nth-child(4)');
                    if (data.is_published) {
                        badgeCell.innerHTML = '<span class="badge bg-success">Active</span>';
                    } else {
                        badgeCell.innerHTML = '<span class="badge bg-warning text-dark">Inactive</span>';
                    }
                    
                    showToast(data.message, 'success');
                } else {
                    showToast('Failed to update status', 'error');
                    btn.innerHTML = originalHtml;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred', 'error');
                btn.innerHTML = originalHtml;
            })
            .finally(() => {
                btn.disabled = false;
            });
        });
    });
    
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed top-0 end-0 m-3`;
        toast.style.zIndex = '9999';
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
});
</script>
@endpush
@endsection
