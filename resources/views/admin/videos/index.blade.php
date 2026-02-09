@extends('layouts.admin')

@section('page_title', 'Video Management')

@section('admin_content')
<div class="row mb-4">
    <div class="col-md-6">
        <h4 class="fw-bold"><i class="fas fa-video me-2 text-primary"></i> Video Management</h4>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-1"></i> Add New Video
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Video URL</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                    <tr>
                        <td>
                            @if($video->thumbnail_path)
                                <img src="{{ asset('uploads/videos/' . $video->thumbnail_path) }}" alt="{{ $video->title }}" style="width: 80px; height: 60px; object-fit: cover;" class="rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width: 80px; height: 60px;">
                                    <i class="fas fa-video text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $video->title }}</strong>
                            @if($video->description)
                                <br><small class="text-muted">{{ Str::limit($video->description, 50) }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-info">{{ $video->category ?? 'General' }}</span></td>
                        <td><small class="text-muted">{{ Str::limit($video->video_url, 30) }}</small></td>
                        <td>
                            <form action="{{ route('admin.videos.toggle', $video->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $video->is_active ? 'btn-success' : 'btn-secondary' }}">
                                    {{ $video->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Delete this video permanently?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-video fa-3x mb-3"></i>
                                <h5>No videos added yet.</h5>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $videos->links() }}
        </div>
    </div>
</div>
@endsection
