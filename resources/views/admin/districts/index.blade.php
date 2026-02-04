@extends('layouts.admin')

@section('page_title', 'Local Districts')

@section('admin_content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card table-card p-4">
            <h6 class="fw-bold mb-3">Add New District</h6>
            <form action="{{ route('admin.districts.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-bold">Parent Division</label>
                    <select name="division_id" class="form-select" required>
                        <option value="">-- Select Division --</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}">{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">District Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Dehradun" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">District Code</label>
                    <input type="text" name="code" class="form-control" placeholder="DDN" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Create District</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Active Districts</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Code</th>
                                <th>District Name</th>
                                <th>Division</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($districts as $district)
                            <tr>
                                <td class="ps-4 fw-bold text-success">{{ $district->code }}</td>
                                <td class="fw-bold">{{ $district->name }}</td>
                                <td><span class="badge bg-info-subtle text-info">{{ $district->division->name }}</span></td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.districts.destroy', $district) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-light btn-sm text-danger"><i class="fas fa-trash"></i></button>
                                    </form>
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
