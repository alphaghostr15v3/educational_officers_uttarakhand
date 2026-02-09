@extends('layouts.admin')

@section('page_title', 'Contact Inquiries')

@section('admin_content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0 text-primary">Incoming Messages</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Status</th>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Received On</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td class="ps-4">
                                @if(!$contact->is_read)
                                    <span class="badge bg-danger rounded-pill">New</span>
                                @else
                                    <span class="badge bg-light text-muted border rounded-pill">Read</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">{{ $contact->full_name }}</div>
                                <div class="small text-muted">{{ $contact->email }}</div>
                                @if($contact->mobile_number)
                                    <div class="small text-muted"><i class="fas fa-phone-alt me-1" style="font-size: 0.7rem;"></i>{{ $contact->mobile_number }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;">{{ $contact->subject }}</div>
                            </td>
                            <td>
                                <div class="small">{{ $contact->created_at->format('d M, Y h:i A') }}</div>
                                <small class="text-muted">{{ $contact->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary" title="View Message">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                <p>No contact inquiries found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($contacts->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection
