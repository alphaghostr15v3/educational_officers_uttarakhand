@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i> Account Issue</h5>
                </div>
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-school fa-4x text-muted"></i>
                    </div>
                    <h4>No School Linked</h4>
                    <p class="text-muted">
                        Your account is registered as a School Clerk/Admin, but it is not linked to any specific school record in our database.
                    </p>
                    <hr>
                    <p class="small text-muted">
                        Please contact the District Education Officer to map your account to your school.
                    </p>
                    <form action="{{ route('school.logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
