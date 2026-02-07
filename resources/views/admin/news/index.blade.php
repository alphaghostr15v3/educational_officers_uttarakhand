@extends('layouts.admin')

@section('page_title', 'News & Notices Management')

@section('admin_content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-newspaper me-2 text-primary"></i> News & Notices</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Publish News
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Title</th>
                        <th>Type</th>
                        <th>Publish Date</th>
                        <th>Status</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" class="rounded me-3" style="width: 50px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-truncate" style="max-width: 300px;">{{ $item->title }}</div>
                                    <small class="text-muted">By {{ $item->creator->name ?? 'Admin' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($item->is_ticker)
                                <span class="badge bg-info text-dark">Ticker</span>
                            @else
                                <span class="badge bg-secondary">Regular</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->publish_date)->format('d M, Y') }}</td>
                        <td>
                            <span class="badge {{ $item->is_published ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $item->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="text-end px-4">
                            <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this news item?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-newspaper fa-3x mb-3"></i>
                            <h5>No news items found.</h5>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($news->hasPages())
    <div class="card-footer bg-white border-0">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection
