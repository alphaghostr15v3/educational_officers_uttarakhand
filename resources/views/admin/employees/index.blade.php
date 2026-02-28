@extends('layouts.admin')

@section('page_title', 'Employee List')

@section('admin_content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            @if(auth()->user()->role === 'admin_panel')
                All Employees
            @else
                Employees in Jurisdiction
            @endif
        </h5>
        <div>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-dark btn-sm px-3 fw-bold">
                <i class="fas fa-user-plus me-1"></i> Add Employee
            </a>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="card-body bg-light border-bottom">
        <form action="{{ route('admin.employees.index') }}" method="GET" class="row g-3">
            @if(isset($divisions) && count($divisions) > 0)
            <div class="col-md-2">
                <select name="division_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Divisions</option>
                    @foreach($divisions as $div)
                        <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(isset($districts) && count($districts) > 0)
            <div class="col-md-2">
                <select name="district_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Districts</option>
                    @foreach($districts as $dist)
                        <option value="{{ $dist->id }}" {{ request('district_id') == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            @if(isset($blocks) && count($blocks) > 0)
            <div class="col-md-2">
                <select name="block_id" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Blocks</option>
                    @foreach($blocks as $blk)
                        <option value="{{ $blk->id }}" {{ request('block_id') == $blk->id ? 'selected' : '' }}>{{ $blk->name }}</option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="col-md-2">
                <select name="designation" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Designations</option>
                    @foreach($designations as $des)
                        <option value="{{ $des->name }}" {{ request('designation') == $des->name ? 'selected' : '' }}>{{ $des->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search by name, code or email..." value="{{ request('search') }}">
                    <button class="btn btn-dark" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['division_id', 'district_id', 'block_id', 'designation', 'search']))
                        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Employee Name</th>
                        <th>Employee Code</th>
                        <th>Designation</th>
                        <th>Current School</th>
                        <th>Mobile</th>
                        <th>Birthday</th>
                        <th class="text-end px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td class="px-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ $employee->image_url }}" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                <div>
                                    <div class="fw-bold">{{ $employee->name }}</div>
                                    <small class="text-muted">{{ $employee->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark fw-normal border">{{ $employee->employee_code ?? 'N/A' }}</span></td>
                        <td>{{ $employee->designation }}</td>
                        <td>{{ $employee->staff->school->name ?? 'N/A' }}</td>
                        <td>{{ $employee->mobile ?? 'N/A' }}</td>
                        <td>
                            @if($employee->dob)
                                @php
                                    $dob = $employee->dob;
                                    $isThisMonth = $dob->month == now()->month;
                                    $isToday = $dob->month == now()->month && $dob->day == now()->day;
                                @endphp
                                <div class="d-flex align-items-center gap-1">
                                    @if($isToday)
                                        <span class="badge bg-warning text-dark">🎂 Today!</span>
                                    @elseif($isThisMonth)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">🎈 This Month</span>
                                    @endif
                                    <div>
                                        <div class="small fw-bold">{{ $dob->format('d M Y') }}</div>
                                        <small class="text-muted">Age: {{ $dob->age }} yrs</small>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted small fst-italic">Not Set</span>
                            @endif
                        </td>
                        <td class="text-end px-4">
                            <div class="btn-group">
                                <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-sm btn-light text-success" title="View Profile">
                                    <i class="fas fa-id-card"></i>
                                </a>
                                <a href="{{ route('admin.promotions.create', ['employee_id' => $employee->id]) }}" class="btn btn-sm btn-light text-primary" title="Grant Promotion">
                                    <i class="fas fa-level-up-alt"></i>
                                </a>
                                <a href="{{ route('admin.transfers.create', ['employee_id' => $employee->id]) }}" class="btn btn-sm btn-light text-warning" title="Initiate Transfer">
                                    <i class="fas fa-exchange-alt"></i>
                                </a>
                                <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-light text-info" title="Edit Employee">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted mb-3">
                                <i class="fas fa-user-slash fa-3x"></i>
                            </div>
                            <h5>No employees found</h5>
                            <p class="text-muted">There are no employee accounts registered in your area yet.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($employees->hasPages())
    <div class="card-footer bg-white py-3">
        {{ $employees->links() }}
    </div>
    @endif
</div>
@endsection
