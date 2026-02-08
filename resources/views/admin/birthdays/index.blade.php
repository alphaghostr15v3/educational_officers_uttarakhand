@extends('layouts.admin')

@section('page_title', 'Birthday Slider Management')

@section('admin_content')
<div class="row mb-4 align-items-center">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-gift me-2 text-primary"></i> Birthday Slider</h4>
        <small class="text-muted">Manage employee birthday entries for the homepage slider</small>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.birthdays.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus me-1"></i> Add Entry
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee</th>
                        <th>Designation</th>
                        <th>Date of Birth</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($birthdays as $item)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item->image_url }}" class="rounded-circle me-3" style="width: 45px; height: 45px; object-fit: cover; border: 2px solid #eee;">
                                <div class="fw-bold text-dark">{{ $item->name }}</div>
                            </div>
                        </td>
                        <td>{{ $item->designation }}</td>
                        <td>{{ $item->dob->format('d M') }} <small class="text-muted">({{ $item->dob->format('Y') }})</small></td>
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $item->id }}" {{ $item->is_active ? 'checked' : '' }}>
                                <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.birthdays.edit', $item->id) }}" class="btn btn-sm btn-outline-primary shadow-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.birthdays.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this birthday entry?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-gift fa-3x mb-3 opacity-25"></i>
                            <h5>No birthday entries found.</h5>
                            <p class="mb-0">Start by adding your first employee birthday entry.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($birthdays->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $birthdays->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.toggle-status').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const id = this.dataset.id;
            fetch(`{{ url('admin/birthdays') }}/${id}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                }
            });
        });
    });
</script>
@endpush
