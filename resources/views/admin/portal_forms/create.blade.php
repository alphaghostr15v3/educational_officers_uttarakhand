@extends('layouts.admin')

@section('page_title', 'Add Portal Item')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">Create Home Page Grid Item</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.portal-forms.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Title (English)</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., FORMS">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Title (Hindi - Optional)</label>
                            <input type="text" name="hindi_title" class="form-control" placeholder="e.g., फॉर्म्स">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Icon Image</label>
                            <input type="file" name="icon" class="form-control" accept="image/*">
                            <div class="form-text small">Square image works best. Max 2MB.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Sort Order</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                        <div class="col-md-12 mt-4">
                            <h6 class="border-bottom pb-2 small fw-bold text-uppercase text-muted">Target Action (Choose One)</h6>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Upload Document (PDF/Doc/Excel)</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <div class="text-center my-2 small text-muted">-- OR --</div>
                            <label class="form-label small fw-bold">External URL / Internal Tool Link</label>
                            <input type="url" name="external_url" class="form-control" placeholder="https://...">
                        </div>
                        
                        <div class="col-12 mt-4 text-end">
                            <a href="{{ route('admin.portal-forms.index') }}" class="btn btn-light px-4 me-2 small">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold">Save Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
