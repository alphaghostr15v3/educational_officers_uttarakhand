@extends('layouts.admin')

@section('page_title', 'Department News & Notices')

@section('admin_content')
<div class="card table-card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Published Updates</h6>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Post News
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td class="ps-4 small text-muted">{{ $item->publish_date }}</td>
                        <td class="fw-bold small">{{ $item->title }}</td>
                        <td>
                            @if($item->is_ticker)
                                <span class="badge bg-warning text-dark small" style="font-size: 0.6rem;">NEWS TICKER</span>
                            @else
                                <span class="badge bg-info small" style="font-size: 0.6rem;">ARTICLE</span>
                            @endif
                        </td>
                        <td><span class="badge bg-success small">Published</span></td>
                        <td class="text-end pe-4">
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted small">No news items found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
