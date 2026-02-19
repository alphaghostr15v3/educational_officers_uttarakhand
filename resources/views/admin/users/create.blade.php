@extends('layouts.admin')

@section('page_title', 'Create New Admin')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Admin Credentials & Role</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Administrative Role</label>
                            <select name="role" class="form-select" id="role-select" required>
                                <option value="state_admin">State Administrator (Full Access)</option>
                                <option value="division_admin">Division Administrator (Regional)</option>
                                <option value="district_admin">District Administrator (Local)</option>
                                <option value="block_admin">Block Administrator (Block Level)</option>
                            </select>
                        </div>

                        <div class="col-md-6" id="division-field" style="display:none;">
                            <label class="form-label small fw-bold">Assign Division</label>
                            <select name="division_id" class="form-select">
                                <option value="">-- Select Division --</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6" id="district-field" style="display:none;">
                            <label class="form-label small fw-bold">Assign District</label>
                            <select name="district_id" class="form-select" id="district-select">
                                <option value="">-- Select District --</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" data-division="{{ $district->division_id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6" id="block-field" style="display:none;">
                            <label class="form-label small fw-bold">Assign Block</label>
                            <select name="block_id" class="form-select" id="block-select">
                                <option value="">-- Select Block --</option>
                                @foreach($blocks as $block)
                                    <option value="{{ $block->id }}" data-district="{{ $block->district_id }}">{{ $block->name }} ({{ $block->district->name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-dark px-5 fw-bold">Create Admin User</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const roleSelect = document.getElementById('role-select');
    const divisionSelect = document.querySelector('select[name="division_id"]');
    const districtSelect = document.querySelector('select[name="district_id"]');
    const blockSelect = document.querySelector('select[name="block_id"]');

    roleSelect.addEventListener('change', function() {
        const role = this.value;
        document.getElementById('division-field').style.display = (role === 'division_admin' || role === 'district_admin' || role === 'block_admin') ? 'block' : 'none';
        document.getElementById('district-field').style.display = (role === 'district_admin' || role === 'block_admin') ? 'block' : 'none';
        document.getElementById('block-field').style.display = (role === 'block_admin') ? 'block' : 'none';
    });

    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;
        const districtOptions = districtSelect.querySelectorAll('option');
        
        districtSelect.value = '';
        blockSelect.value = '';
        
        districtOptions.forEach(opt => {
            if (!opt.value) return; // Skip placeholder
            opt.style.display = (!divisionId || opt.dataset.division === divisionId) ? 'block' : 'none';
        });
    });

    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        const blockOptions = blockSelect.querySelectorAll('option');
        
        blockSelect.value = '';
        
        blockOptions.forEach(opt => {
            if (!opt.value) return; // Skip placeholder
            opt.style.display = (!districtId || opt.dataset.district === districtId) ? 'block' : 'none';
        });
    });
</script>
@endpush
@endsection
