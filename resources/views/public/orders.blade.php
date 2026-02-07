@extends('layouts.public')

@section('content')
<div class="bg-primary text-white py-5 mb-5 shadow-sm">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold">Orders & Circulars</h1>
                <p class="lead mb-0">Browse latest departmental government orders, transfers, and notices.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <form action="{{ route('orders') }}" method="GET" class="input-group">
                    <input type="hidden" name="category" value="{{ $category ?? 'all' }}">
                    <input type="text" name="search" class="form-control" placeholder="Search orders..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-warning"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Categories -->
        <div class="col-md-3">
            <h5 class="fw-bold mb-3">Categories</h5>
            <div class="list-group shadow-sm mb-4">
                <a href="{{ route('orders', ['category' => 'all']) }}" class="list-group-item list-group-item-action {{ (!$category || $category == 'all') ? 'active' : '' }}">All Orders</a>
                <a href="{{ route('orders', ['category' => 'transfer']) }}" class="list-group-item list-group-item-action {{ $category == 'transfer' ? 'active' : '' }}">Transfer Orders</a>
                <a href="{{ route('orders', ['category' => 'promotion']) }}" class="list-group-item list-group-item-action {{ $category == 'promotion' ? 'active' : '' }}">Promotion Orders</a>
                <a href="{{ route('orders', ['category' => 'govt_order']) }}" class="list-group-item list-group-item-action {{ $category == 'govt_order' ? 'active' : '' }}">Govt. Orders (GO)</a>
                <a href="{{ route('orders', ['category' => 'notice']) }}" class="list-group-item list-group-item-action {{ $category == 'notice' ? 'active' : '' }}">General Notices</a>
                <a href="{{ route('orders', ['category' => 'circular']) }}" class="list-group-item list-group-item-action {{ $category == 'circular' ? 'active' : '' }}">Circulars</a>
            </div>
            
            <h5 class="fw-bold mb-3">Quick Tools</h5>
            <div class="list-group shadow-sm">
                <a href="{{ route('tools.hindi-converter') }}" class="list-group-item list-group-item-action">Hindi Converter</a>
                <a href="{{ route('tools.compress-pdf') }}" class="list-group-item list-group-item-action">PDF Compressor</a>
            </div>
        </div>

        <!-- Orders List -->
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">No. / Date</th>
                                    <th>Title & Subject</th>
                                    <th>Category</th>
                                    <th class="text-center">Download</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-primary">#{{ $category === 'circular' ? $item->circular_number : $item->order_number }}</div>
                                        <div class="small text-muted">{{ $category === 'circular' ? $item->circular_date : $item->order_date }}</div>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $item->title }}</div>
                                        @if($item->description)
                                            <p class="small text-muted mb-0">{{ Str::limit($item->description, 100) }}</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if($category === 'circular')
                                            <span class="badge bg-info-subtle text-info">Circular</span>
                                        @else
                                            <span class="badge bg-primary-subtle text-primary">{{ ucfirst($item->category) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ asset('uploads/' . ($category === 'circular' ? 'circulars/' : 'orders/') . $item->file_path) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="https://cdni.iconscout.com/illustration/premium/thumb/no-data-found-8867280-7265556.png" alt="No data" style="height: 150px;" class="mb-3 d-block mx-auto">
                                        <h6 class="text-muted">No records found for this category.</h6>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
