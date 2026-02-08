@extends('layouts.admin')

@section('page_title', 'Manage School Login')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-key me-2"></i>Login Credentials for {{ $school->name }}</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.schools.login.store', $school) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Display Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $login->name ?? $school->name . ' Clerk') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address (Username)</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $login->email ?? '') }}" required placeholder="e.g. gic.raipur@edu.in">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Password {{ $login ? '(Leave blank to keep current)' : '' }}</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               {{ $login ? '' : 'required' }}>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-save me-2"></i> {{ $login ? 'Update Login Account' : 'Create Login Account' }}
                        </button>
                        <a href="{{ route('admin.schools.show', $school) }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
