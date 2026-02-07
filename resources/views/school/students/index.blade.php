@extends('layouts.school')

@section('page_title', 'Student Strength')

@section('school_content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Manage Student Strength</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('school.students.update') }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Class Group</th>
                                    <th>Stream (Optional)</th>
                                    <th width="20%">Boys</th>
                                    <th width="20%">Girls</th>
                                    <th width="15%">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classGroups as $group)
                                @php
                                    $record = $strengths[$group] ?? null;
                                @endphp
                                <tr>
                                    <td class="fw-bold bg-light">{{ $group }}</td>
                                    <td>
                                        @if($group === 'Class 11-12')
                                            <input type="text" name="strengths[{{ $group }}][stream]" class="form-control form-control-sm" placeholder="e.g. Science" value="{{ $record->stream ?? '' }}">
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="number" name="strengths[{{ $group }}][boys]" class="form-control text-center boys-input" value="{{ $record->boys ?? 0 }}" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="strengths[{{ $group }}][girls]" class="form-control text-center girls-input" value="{{ $record->girls ?? 0 }}" min="0">
                                    </td>
                                    <td class="text-center fw-bold total-display">
                                        {{ $record->total ?? 0 }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
