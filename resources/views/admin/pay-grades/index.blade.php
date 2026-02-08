@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Pay Grades</h3>
                    <a href="{{ route('admin.pay-grades.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Pay Grade
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name (Level)</th>
                                    <th>Pay Scale Range</th>
                                    <th>Grade Pay</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payGrades as $payGrade)
                                    <tr>
                                        <td>{{ $payGrade->id }}</td>
                                        <td>{{ $payGrade->name }}</td>
                                        <td>{{ $payGrade->range }}</td>
                                        <td>{{ $payGrade->grade_pay ?? '-' }}</td>
                                        <td>
                                            @if($payGrade->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.pay-grades.edit', $payGrade) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.pay-grades.destroy', $payGrade) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No pay grades found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $payGrades->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
