@extends('layouts.admin')

@section('page_title', 'Home Page Grid Items')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Portal Forms & Quick Links</h6>
        <a href="{{ route('admin.portal-forms.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Add New Item
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 80px;">Icon</th>
                        <th>Title (English / Hindi)</th>
                        <th>Target</th>
                        <th>Order</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($forms as $form)
                    <tr>
                        <td class="ps-4">
                            @if($form->icon)
                                <img src="{{ asset('uploads/portal/icons/' . $form->icon) }}" class="rounded shadow-sm" style="width: 40px; height: 40px; object-fit: contain; background: #f8f9fa;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold small text-dark">{{ $form->title }}</div>
                            @if($form->hindi_title)
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $form->hindi_title }}</div>
                            @endif
                        </td>
                        <td>
                            @if($form->file_path)
                                <span class="badge bg-primary-subtle text-primary small"><i class="fas fa-file-download me-1"></i> File</span>
                            @elseif($form->external_url)
                                <span class="badge bg-info-subtle text-info small"><i class="fas fa-external-link-alt me-1"></i> Link</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary small">Undefined</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $form->sort_order }}</small></td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.portal-forms.edit', $form) }}" class="btn btn-light btn-sm text-primary"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.portal-forms.destroy', $form) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted small">No items found. Start by adding a "Form" or "Quick Link".</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
