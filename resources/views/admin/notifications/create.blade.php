@extends('layouts.admin')

@section('page_title', 'Send Notification')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Compose New Announcement</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.notifications.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="Short descriptive title">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Message <span class="text-danger">*</span></label>
                        <textarea name="message" class="form-control" rows="5" required placeholder="Detailed message content..."></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Notification Type</label>
                            <select name="type" class="form-select">
                                <option value="info">Information (Blue)</option>
                                <option value="success">Success (Green)</option>
                                <option value="warning">Warning (Yellow)</option>
                                <option value="danger">Urgent/Danger (Red)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Target Group / Role</label>
                            <select name="target_role" class="form-select">
                                <option value="">Target All Users</option>
                                <option value="employee">Staff (Educational Ministerial Officers)</option>
                                <option value="school_admin">School Admins (Clerks)</option>
                                <option value="district_admin">District Admins</option>
                                <option value="division_admin">Division Admins</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Send Notification</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
