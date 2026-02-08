@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Sanctioned Posts</h3>
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Post
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <select name="level" class="form-control" onchange="this.form.submit()">
                                    <option value="">Filter by Level</option>
                                    <option value="state" {{ request('level') == 'state' ? 'selected' : '' }}>State</option>
                                    <option value="division" {{ request('level') == 'division' ? 'selected' : '' }}>Division</option>
                                    <option value="district" {{ request('level') == 'district' ? 'selected' : '' }}>District</option>
                                    <option value="school" {{ request('level') == 'school' ? 'selected' : '' }}>School</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="designation_id" class="form-control" onchange="this.form.submit()">
                                    <option value="">Filter by Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ request('designation_id') == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Reset Filters</a>
                            </div>
                        </div>
                    </form>
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Designation</th>
                                    <th>Level</th>
                                    <th>Office/School</th>
                                    <th>Sanctioned Count</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->designation->name }}</td>
                                        <td><span class="badge badge-info">{{ ucfirst($post->level) }}</span></td>
                                        <td>
                                            @if($post->level == 'school')
                                                School: {{ $post->school ? $post->school->name : 'N/A' }}
                                            @elseif($post->level == 'district')
                                                District: {{ $post->district ? $post->district->name : 'N/A' }}
                                            @elseif($post->level == 'division')
                                                Division: {{ $post->division ? $post->division->name : 'N/A' }}
                                            @else
                                                State Office
                                            @endif
                                        </td>
                                        <td>{{ $post->sanctioned_count }}</td>
                                        <td>
                                            @if($post->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No posts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $posts->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
