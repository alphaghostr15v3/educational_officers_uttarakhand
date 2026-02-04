@extends('layouts.admin')

@section('page_title', 'Regional Divisions')

@section('admin_content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card table-card p-4">
            <h6 class="fw-bold mb-3">Add New Division</h6>
            <form action="{{ route('admin.divisions.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Division Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Garhwal" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Division Code</label>
                    <input type="text" name="code" class="form-control" placeholder="GRL" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Save Division</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Established Divisions</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>Division Name</th>
                                <th>Districts</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($divisions as $division)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $division->code }}</td>
                                <td class="fw-bold">{{ $division->name }}</td>
                                <td><span class="badge bg-secondary">{{ $division->districts_count }}</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm text-primary me-2" data-bs-toggle="modal" data-bs-target="#editDivision{{ $division->id }}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.divisions.destroy', $division) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-light btn-sm text-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editDivision{{ $division->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Edit Division: {{ $division->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.divisions.update', $division) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Division Name</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $division->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Division Code</label>
                                                            <input type="text" name="code" class="form-control" value="{{ $division->code }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold">Update Division</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
