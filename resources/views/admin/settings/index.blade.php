@extends('layouts.admin')

@section('page_title', 'System Settings')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Global Portal Configuration</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <h6 class="fw-bold text-muted border-bottom pb-2 small text-uppercase">General Information</h6>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Site Title</label>
                            <input type="text" name="site_title" class="form-control" value="{{ $settings['site_title'] ?? 'Educational Ministerial Officers Portal' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contact Email</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'info@uk-edu-ministerial.gov.in' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Contact Phone</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '+91 135 1234567' }}">
                        </div>
                        <div class="col-md-12 mt-4">
                            <h6 class="fw-bold text-muted border-bottom pb-2 small text-uppercase">Portal Features</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_voting" {{ ($settings['enable_voting'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold">Enable Digital Voting Portal</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enable_donations" {{ ($settings['enable_donations'] ?? 'on') == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold">Enable Public Donation Section</label>
                            </div>
                        </div>
                        <div class="col-12 mt-5 text-end border-top pt-3">
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Save Configuration</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
