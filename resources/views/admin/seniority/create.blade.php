@extends('layouts.admin')

@section('page_title', 'Upload Seniority List')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Seniority List Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.seniority.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Final Seniority List of Administrative Officers">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Year <span class="text-danger">*</span></label>
                            <input type="number" name="year" class="form-control" required min="2000" max="{{ date('Y') + 1 }}" value="{{ date('Y') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Cadre <span class="text-danger">*</span></label>
                            <select name="cadre" class="form-select" required>
                                <option value="" disabled selected>Select Cadre</option>
                                <option value="Administrative Officer">Administrative Officer</option>
                                <option value="Senior Administrative Officer">Senior Administrative Officer</option>
                                <option value="Chief Administrative Officer">Chief Administrative Officer</option>
                                <option value="Senior Assistant">Senior Assistant</option>
                                <option value="Junior Assistant">Junior Assistant</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-uppercase text-muted">PDF Document <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" required accept=".pdf">
                        <div class="form-text">Max file size: 10MB. Format: PDF only.</div>
                    </div>

                    <div class="d-flex justify-content-between pt-3">
                        <a href="{{ route('admin.seniority.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="fas fa-cloud-upload-alt me-2"></i> Upload List</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
