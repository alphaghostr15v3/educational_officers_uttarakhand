@extends('layouts.admin')

@section('page_title', 'Configure Election')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-primary">New Election Details</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.elections.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Election Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. State President Election 2024" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Election Level</label>
                            <select name="level" class="form-select" id="level-select" required>
                                <option value="state">State Level</option>
                                <option value="division">Division Level</option>
                                <option value="district">District Level</option>
                            </select>
                        </div>
                        <div class="col-md-6" id="division-col" style="display:none;">
                            <label class="form-label small fw-bold">Division</label>
                            <select name="division_id" class="form-select">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6" id="district-col" style="display:none;">
                            <label class="form-label small fw-bold">District</label>
                            <select name="district_id" class="form-select">
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Start Date & Time</label>
                            <input type="datetime-local" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">End Date & Time</label>
                            <input type="datetime-local" name="end_date" class="form-control" required>
                        </div>
                        <div class="col-12 mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Create Draft</button>
                            <a href="{{ route('admin.elections.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('level-select').addEventListener('change', function() {
        const level = this.value;
        document.getElementById('division-col').style.display = (level === 'division' || level === 'district') ? 'block' : 'none';
        document.getElementById('district-col').style.display = (level === 'district') ? 'block' : 'none';
    });
</script>
@endpush
@endsection
