@extends('layouts.admin')

@section('page_title', 'Upload Government Order')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card table-card">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-success"><i class="fas fa-file-upload me-2"></i>Order Metadata</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.orders.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Order Title / Subject</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Promotion of Junior Assistants Oct 2024" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Order Number</label>
                            <input type="text" name="order_number" class="form-control" placeholder="#UK-EDU-88" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Order Date</label>
                            <input type="date" name="order_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Category</label>
                            <select name="category" class="form-select" required>
                                <option value="transfer">Transfer Order</option>
                                <option value="promotion">Promotion Order</option>
                                <option value="govt_order">Government Order (GO)</option>
                                <option value="notice">General Notice</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Jurisdiction Level</label>
                            <select name="level" class="form-select" required>
                                <option value="state">State Level</option>
                                <option value="division">Division Level</option>
                                <option value="district">District Level</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">Division (Optional)</label>
                            <select name="division_id" class="form-select">
                                <option value="">None</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted">District (Optional)</label>
                            <select name="district_id" class="form-select">
                                <option value="">None</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">PDF Document</label>
                            <input type="file" name="file" class="form-control" accept=".pdf" required>
                            <div class="form-text small">Only PDF files up to 10MB are allowed.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-12 mt-4 pt-3 border-top text-end">
                            <button type="submit" class="btn btn-success px-5 fw-bold">Upload & Publish</button>
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-light px-4 ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
