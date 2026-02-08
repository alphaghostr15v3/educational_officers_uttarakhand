@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Designations</h3>
                    <a href="{{ route('admin.designations.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Designation
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Level</th>
                                    <th>Name</th>
                                    <th>Parent Designation</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($designations as $designation)
                                    <tr>
                                        <td>{{ $designation->id }}</td>
                                        <td><span class="badge badge-info">{{ ucfirst($designation->level) }}</span></td>
                                        <td>{{ $designation->name }}</td>
                                        <td>{{ $designation->parent ? $designation->parent->name : '-' }}</td>
                                        <td>{{ $designation->order }}</td>
                                        <td>
                                            @if($designation->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.designations.edit', $designation) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.designations.destroy', $designation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                                        <td colspan="7" class="text-center">No designations found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $designations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
