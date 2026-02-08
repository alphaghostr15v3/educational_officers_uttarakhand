@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Sanctioned Post</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.update', $post) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label>Designation</label>
                            <input type="text" class="form-control" value="{{ $post->designation->name }}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label>Level</label>
                            <input type="text" class="form-control" value="{{ ucfirst($post->level) }}" disabled>
                        </div>

                         @if($post->level == 'school')
                            <div class="form-group mb-3">
                                <label>School</label>
                                <input type="text" class="form-control" value="{{ $post->school ? $post->school->name : 'N/A' }}" disabled>
                            </div>
                        @elseif($post->level == 'district')
                            <div class="form-group mb-3">
                                <label>District</label>
                                <input type="text" class="form-control" value="{{ $post->district ? $post->district->name : 'N/A' }}" disabled>
                            </div>
                        @elseif($post->level == 'division')
                            <div class="form-group mb-3">
                                <label>Division</label>
                                <input type="text" class="form-control" value="{{ $post->division ? $post->division->name : 'N/A' }}" disabled>
                            </div>
                        @else
                            <div class="form-group mb-3">
                                <label>Office</label>
                                <input type="text" class="form-control" value="State Office" disabled>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="sanctioned_count">Sanctioned Count <span class="text-danger">*</span></label>
                            <input type="number" name="sanctioned_count" id="sanctioned_count" class="form-control @error('sanctioned_count') is-invalid @enderror" value="{{ old('sanctioned_count', $post->sanctioned_count) }}" min="0" required>
                            @error('sanctioned_count')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $post->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
