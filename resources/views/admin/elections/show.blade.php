@extends('layouts.admin')

@section('page_title', 'Manage Candidates')

@section('admin_content')
<div class="row g-4">
    <!-- Election Info -->
    <div class="col-md-4">
        <div class="card table-card p-4 h-100">
            <h5 class="fw-bold mb-3 border-bottom pb-2">Election Info</h5>
            <div class="mb-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Title</small>
                <div class="fw-bold">{{ $election->title }}</div>
            </div>
            <div class="mb-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Status</small>
                <div>
                    <span class="badge {{ $election->status == 'active' ? 'bg-success' : 'bg-warning text-dark' }}">{{ ucfirst($election->status) }}</span>
                </div>
            </div>
            <div class="mb-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Jurisdiction</small>
                <div class="small">
                    <strong>Level:</strong> {{ ucfirst($election->level) }}<br>
                    @if($election->division) <strong>Division:</strong> {{ $election->division->name }}<br> @endif
                    @if($election->district) <strong>District:</strong> {{ $election->district->name }} @endif
                </div>
            </div>
            <div class="mb-4">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem;">Timeline</small>
                <div class="small">
                    <strong>Starts:</strong> {{ \Carbon\Carbon::parse($election->start_date)->format('d M y, H:i') }}<br>
                    <strong>Ends:</strong> {{ \Carbon\Carbon::parse($election->end_date)->format('d M y, H:i') }}
                </div>
            </div>
            
            @if($election->status === 'draft')
            <form action="{{ route('admin.elections.activate', $election) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success w-100 fw-bold">
                    <i class="fas fa-play me-2"></i> ACTIVATE ELECTION
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Candidate Management -->
    <div class="col-md-8">
        <div class="card table-card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Nominated Candidates</h6>
                @if($election->status === 'draft')
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCandidateModal">
                    <i class="fas fa-plus me-1"></i> Add Candidate
                </button>
                @endif
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Officer Name</th>
                                <th>Designation</th>
                                <th>District</th>
                                <th>Votes</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($election->candidates as $candidate)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="https://ui-avatars.com/api/?name={{ $candidate->officer->name }}&background=random" class="rounded-circle me-2" style="width: 32px;">
                                        <div class="fw-bold small">{{ $candidate->officer->name }}</div>
                                    </div>
                                </td>
                                <td><span class="small text-muted">{{ $candidate->officer->designation }}</span></td>
                                <td><span class="small">{{ $candidate->officer->district->name }}</span></td>
                                <td><span class="badge bg-primary">{{ $candidate->votes_count ?? 0 }}</span></td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-light btn-sm text-danger"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted small">No candidates nominated yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Candidate Modal -->
<div class="modal fade" id="addCandidateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Nominate Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.elections.candidates.add', $election) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Officer</label>
                        <select name="officer_id" class="form-select border-2" required>
                            <option value="">-- Choose Officer --</option>
                            @foreach($officers as $officer)
                                <option value="{{ $officer->id }}">{{ $officer->name }} ({{ $officer->designation }} - {{ $officer->district->name }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">Add to Election</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
