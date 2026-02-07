@extends('layouts.school')

@section('title', 'Notices & Circulars')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Notices & Circulars</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
         <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Circular No</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($circulars as $circular)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($circular->circular_date)->format('d M Y') }}</td>
                            <td>{{ $circular->circular_number }}</td>
                            <td>
                                <span class="fw-bold">{{ $circular->title }}</span>
                                @if($circular->is_new)
                                    <span class="badge bg-danger ms-2">New</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info text-dark">{{ ucfirst($circular->level) }}</span>
                            </td>
                            <td>
                                <a href="{{ Storage::url($circular->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i> View/Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No circulars found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $circulars->links() }}
    </div>
</div>
@endsection
