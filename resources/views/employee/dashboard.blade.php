@extends('layouts.employee')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-muted">Education Ministerial Officers Association Uttarakhand Employee Portal</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-file-alt text-primary fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Official Orders</h6>
                            <h2 class="mb-0">{{ $stats['total_orders'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('orders') }}" class="small text-primary text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-bullhorn text-success fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Circulars</h6>
                            <h2 class="mb-0">{{ $stats['total_circulars'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#" class="small text-success text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-list-ol text-warning fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Seniority Lists</h6>
                            <h2 class="mb-0">{{ $stats['total_seniority_lists'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="{{ route('seniority') }}" class="small text-warning text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-newspaper text-info fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase fw-bold text-muted small mb-1">Latest News</h6>
                            <h2 class="mb-0">{{ $stats['total_news'] }}</h2>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0 pt-0">
                    <a href="#" class="small text-info text-decoration-none">Read News <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Recent Official Orders</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4">Title</th>
                                    <th>Date</th>
                                    <th class="text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_orders as $order)
                                <tr>
                                    <td class="px-4">
                                        <div class="fw-semibold">{{ $order->title }}</div>
                                        <span class="small text-muted">{{ $order->category }}</span>
                                    </td>
                                    <td>{{ $order->updated_at->format('d M, Y') }}</td>
                                    <td class="text-end px-4">
                                        <a href="{{ asset('storage/' . $order->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">No recent orders found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- News Feed -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-primary">Latest News</h6>
                </div>
                <div class="card-body">
                    <div class="news-list">
                        @forelse($recent_news as $news)
                        <div class="mb-3 pb-3 border-bottom {{ $loop->last ? 'border-0 mb-0 pb-0' : '' }}">
                            <div class="small text-primary fw-bold mb-1">{{ $news->updated_at->format('d M, Y') }}</div>
                            <h6 class="fw-bold mb-1">{{ $news->title }}</h6>
                            <p class="small text-muted mb-0">{{ Str::limit($news->content, 80) }}</p>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted">No news updates.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
