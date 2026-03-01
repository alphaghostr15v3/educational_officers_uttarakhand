@extends('layouts.admin')

@section('page_title', 'Anshandan Management')

@section('admin_content')
<div class="container-fluid">
    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <h6 class="text-muted mb-3"><i class="fas fa-filter me-2"></i>Filter Records</h6>
            <form action="{{ route('admin.anshandan.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="small text-muted mb-1">Year</label>
                    <select name="year" class="form-select form-select-sm shadow-none">
                        <option value="">All Years</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted mb-1">Division</label>
                    <select name="division_id" class="form-select form-select-sm shadow-none" onchange="this.form.submit()">
                        <option value="">All Divisions</option>
                        @foreach($divisions as $div)
                            <option value="{{ $div->id }}" {{ request('division_id') == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted mb-1">District</label>
                    <select name="district_id" class="form-select form-select-sm shadow-none" onchange="this.form.submit()">
                        <option value="">All Districts</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist->id }}" {{ request('district_id') == $dist->id ? 'selected' : '' }}>{{ $dist->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small text-muted mb-1">Block</label>
                    <select name="block_id" class="form-select form-select-sm shadow-none" onchange="this.form.submit()">
                        <option value="">All Blocks</option>
                        @foreach($blocks as $blk)
                            <option value="{{ $blk->id }}" {{ request('block_id') == $blk->id ? 'selected' : '' }}>{{ $blk->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 text-end mt-3">
                    <a href="{{ route('admin.anshandan.index') }}" class="btn btn-sm btn-outline-secondary me-2">Reset</a>
                    <button type="submit" class="btn btn-sm btn-primary px-4">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
                <p class="text-uppercase small mb-1" style="opacity: 0.8; font-weight: 600;">Total Amount</p>
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"><i class="fas fa-hand-holding-usd fa-2x"></i></div>
                    <h2 class="mb-0 fw-bold">₹{{ number_format($total_amount, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm text-white" style="background: linear-gradient(135deg, #0ba360 0%, #3cba92 100%); border-radius: 12px;">
                <p class="text-uppercase small mb-1" style="opacity: 0.8; font-weight: 600;">Provincial Share (40%)</p>
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"><i class="fas fa-university fa-2x"></i></div>
                    <h2 class="mb-0 fw-bold">₹{{ number_format($provincial_share, 2) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-3 shadow-sm text-white" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px;">
                <p class="text-uppercase small mb-1" style="opacity: 0.8; font-weight: 600;">Mandal Share (20%)</p>
                <div class="d-flex align-items-center">
                    <div class="icon-box me-3"><i class="fas fa-layer-group fa-2x"></i></div>
                    <h2 class="mb-0 fw-bold">₹{{ number_format($mandal_share, 2) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Column Visibility & Exports -->
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h6 class="text-muted small mb-2"><i class="fas fa-columns me-2"></i>Select Columns to Export/Print</h6>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach(['S.No', 'User Name', 'Block', 'District', 'Division', 'Designation', 'Team Member Designation', 'Current Office', 'Year', 'Amount', 'Depositor Name'] as $col)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input col-toggle" type="checkbox" id="col_{{ \Str::slug($col) }}" value="{{ $loop->index }}" checked>
                            <label class="form-check-label small" for="col_{{ \Str::slug($col) }}">{{ $col }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <button class="btn btn-sm btn-success me-1" onclick="printSelected()"><i class="fas fa-print me-1"></i> Print Selected</button>
                    <button class="btn btn-sm btn-primary me-1"><i class="fas fa-file-excel me-1"></i> Excel Selected</button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-file-pdf me-1"></i> PDF Selected</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="anshandanTable">
                    <thead style="background: #6f42c1; color: white;">
                        <tr>
                            <th class="py-3 px-3"><input type="checkbox" id="selectAll" class="form-check-input me-2"> S.No</th>
                            <th class="py-3">USER NAME</th>
                            <th class="py-3">BLOCK</th>
                            <th class="py-3">DISTRICT</th>
                            <th class="py-3">DIVISION</th>
                            <th class="py-3">DESIGNATION</th>
                            <th class="py-3">TEAM MEMBER DESIGNATION</th>
                            <th class="py-3">CURRENT OFFICE/SCHOOL</th>
                            <th class="py-3">YEAR</th>
                            <th class="py-3">AMOUNT</th>
                            <th class="py-3">DEPOSITOR NAME</th>
                            <th class="py-3 text-center action-col">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anshandans as $item)
                        <tr>
                            <td class="px-3"><input type="checkbox" class="form-check-input me-2 row-select" value="{{ $item->id }}"> {{ ($anshandans->currentPage()-1) * $anshandans->perPage() + $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold">{{ $item->member_name }}</div>
                                <small class="text-muted">{{ $item->user->employee_code ?? 'na' }}</small>
                            </td>
                            <td>{{ $item->block->name ?? 'na' }}</td>
                            <td>{{ $item->district->name }}</td>
                            <td><span class="badge bg-light text-dark hvr-division">{{ $item->district->division->name ?? 'na' }}</span></td>
                            <td>{{ $item->user->staff->designation ?? 'na' }}</td>
                            <td>na</td> <!-- Team Member Designation Placeholder -->
                            <td><small>{{ $item->user->staff->school->name ?? 'na' }}</small></td>
                            <td>{{ $item->year }}</td>
                            <td class="fw-bold text-primary">₹{{ number_format($item->amount, 2) }}</td>
                            <td>na</td> <!-- Depositor Name Placeholder -->
                            <td class="text-center action-col">
                                <div class="btn-group">
                                    <a href="{{ route('admin.anshandan.show', $item->id) }}" class="btn btn-sm btn-outline-info" title="Print/View" target="_blank">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    <a href="{{ route('admin.anshandan.download', $item->id) }}" class="btn btn-sm btn-outline-success" title="Download PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <form action="{{ route('admin.anshandan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="text-muted">No records found matching your filters.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($anshandans->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="small text-muted">
                    Showing {{ $anshandans->firstItem() }} to {{ $anshandans->lastItem() }} of {{ $anshandans->total() }} records
                </div>
                {{ $anshandans->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .hvr-division { border: 1px solid #eee; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; }
    .stat-card { transition: transform 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .table thead th { border-bottom: 0; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; }
    .table tbody td { border-bottom: 1px solid #f8f9fa; font-size: 0.85rem; }
    .form-select-sm { background-color: #fcfcfc; border: 1px solid #eee; }
    .icon-box { background: rgba(255,255,255,0.2); width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
    .btn-outline-info { border-color: #17a2b8; color: #17a2b8; }
    .btn-outline-info:hover { background: #17a2b8; color: white; }

    @media print {
        .no-print, .action-col, .form-check-input, .card-footer, .filter-section, .navbar, .sidebar { display: none !important; }
        .card { border: 0 !important; shadow: none !important; }
        .table { width: 100% !important; }
        body { background: white !important; }
    }
</style>

@push('scripts')
<script>
    // Column Visibility Toggle
    document.querySelectorAll('.col-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const colIndex = parseInt(this.value);
            const table = document.getElementById('anshandanTable');
            const rows = table.querySelectorAll('tr');
            
            rows.forEach(row => {
                const cell = row.children[colIndex];
                if (cell) {
                    cell.style.display = this.checked ? '' : 'none';
                }
            });
        });
    });

    // Select All Checkbox
    document.getElementById('selectAll').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('.row-select').forEach(cb => {
            cb.checked = isChecked;
        });
    });

    // Print Selected Logic
    function printSelected() {
        const selectedIds = Array.from(document.querySelectorAll('.row-select:checked')).map(cb => cb.value);
        if (selectedIds.length === 0) {
            alert('Please select at least one record to print.');
            return;
        }

        // We hide unselected rows temporarily for printing
        const table = document.getElementById('anshandanTable');
        const rows = table.querySelectorAll('tbody tr');
        let hiddenRows = [];

        rows.forEach(row => {
            const cb = row.querySelector('.row-select');
            if (!cb.checked) {
                row.classList.add('no-print');
                hiddenRows.push(row);
            }
        });

        window.print();

        // Restore rows
        hiddenRows.forEach(row => row.classList.remove('no-print'));
    }
</script>
@endpush

@endsection
