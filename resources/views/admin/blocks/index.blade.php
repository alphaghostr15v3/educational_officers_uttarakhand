@extends('layouts.admin')

@section('page_title', 'Administrative Blocks')

@section('admin_content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card table-card p-4">
            <h6 class="fw-bold mb-3">Add New Block</h6>
            <form action="{{ route('admin.blocks.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">District</label>
                    <select name="district_id" class="form-select" required>
                        <option value="">-- Select District --</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Block Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Doiwala" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Block Code</label>
                    <input type="text" name="code" class="form-control" placeholder="DOI" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Create Block</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Active Blocks</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>Block Name</th>
                                <th>District</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blocks as $block)
                            <tr>
                                <td class="ps-4 fw-bold text-success">{{ $block->code }}</td>
                                <td class="fw-bold">{{ $block->name }}</td>
                                <td><span class="badge bg-info-subtle text-info">{{ $block->district->name }}</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm text-primary me-2" data-bs-toggle="modal" data-bs-target="#editBlock{{ $block->id }}"><i class="fas fa-edit"></i></button>
                                    <form action="{{ route('admin.blocks.destroy', $block) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-light btn-sm text-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                    </form>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editBlock{{ $block->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-start">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold">Edit Block: {{ $block->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.blocks.update', $block) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">District</label>
                                                            <select name="district_id" class="form-select" required>
                                                                @foreach($districts as $dist)
                                                                    <option value="{{ $dist->id }}" {{ $block->district_id == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Block Name</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $block->name }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Block Code</label>
                                                            <input type="text" name="code" class="form-control" value="{{ $block->code }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold">Update Block</button>
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
