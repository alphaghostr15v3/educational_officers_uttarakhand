@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Upload Works</h2>
        <p class="text-muted">Download various work forms and documents</p>
    </div>

    <div class="row g-4">
        @foreach($workForms as $workType => $forms)
            @php
                $icons = [
                    'Forms' => 'fa-file-alt',
                    'Pannat' => 'fa-clipboard-list',
                    'Income Tax' => 'fa-calculator',
                    'Pension Data' => 'fa-user-clock',
                    'Government Orders' => 'fa-file-contract',
                    'Promotion Orders' => 'fa-award',
                    'House Rent Allowance' => 'fa-home',
                    'Dearness Allowance Rent' => 'fa-money-bill-wave',
                    'General Provident Fund' => 'fa-piggy-bank',
                    'Transfer Orders' => 'fa-exchange-alt'
                ];
                $icon = $icons[$workType] ?? 'fa-file';
                
                $colors = [
                    'Forms' => '#0d6efd',
                    'Pannat' => '#198754',
                    'Income Tax' => '#ffc107',
                    'Pension Data' => '#0dcaf0',
                    'Government Orders' => '#dc3545',
                    'Promotion Orders' => '#6f42c1',
                    'House Rent Allowance' => '#fd7e14',
                    'Dearness Allowance Rent' => '#20c997',
                    'General Provident Fund' => '#6610f2',
                    'Transfer Orders' => '#d63384'
                ];
                $color = $colors[$workType] ?? '#6c757d';
            @endphp
            <div class="col-6 col-md-4 col-lg-3">
                <a href="{{ route('work-forms.by-type', urlencode($workType)) }}" class="text-decoration-none">
                    <div class="card h-100 border-0 shadow-sm hover-lift text-center p-4">
                        <div class="mb-3">
                            <div class="icon-wrapper mx-auto" style="width: 70px; height: 70px; background: {{ $color }}; border-radius: 18px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px {{ $color }}44;">
                                <i class="fas {{ $icon }} fa-2x text-white"></i>
                            </div>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark">{{ $workType }}</h6>
                        <span class="badge bg-light text-muted fw-normal">{{ $forms->count() }} Files</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<style>
.hover-lift {
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
}
.hover-lift:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}
.card {
    border-radius: 15px;
}
</style>
@endsection
