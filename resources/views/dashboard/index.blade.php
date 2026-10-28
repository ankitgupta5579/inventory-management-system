@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
{{-- Stat cards --}}
<div class="row g-3 mb-4">
    @php
        $cards = [
            ['Total Products',  $totalProducts,  'bi-box',                'bg-primary'],
            ['Suppliers',       $totalSuppliers, 'bi-truck',              'bg-success'],
            ["Today's Sales",   '₹' . number_format($todaySales, 2), 'bi-currency-rupee', 'bg-info'],
            ['Low Stock Items', $lowStockCount,  'bi-exclamation-triangle','bg-danger'],
        ];
    @endphp

    @foreach($cards as [$label, $value, $icon, $color])
        <div class="col-md-6 col-xl-3">
            <div class="card stat-card p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-box {{ $color }} me-3"><i class="bi {{ $icon }}"></i></div>
                    <div>
                        <div class="text-muted small">{{ $label }}</div>
                        <h4 class="mb-0">{{ $value }}</h4>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    {{-- Low stock alert table --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white fw-bold text-danger">
                <i class="bi bi-bell"></i> Low Stock Alerts
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Product</th><th>Stock</th><th>Reorder Level</th></tr></thead>
                    <tbody>
                    @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge bg-danger">{{ $product->quantity }}</span></td>
                            <td>{{ $product->reorder_level }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">All products are well stocked 🎉</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent sales --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white fw-bold"><i class="bi bi-receipt"></i> Recent Sales</div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light"><tr><th>Invoice</th><th>Customer</th><th>Total</th></tr></thead>
                    <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td>#{{ $sale->id }}</td>
                            <td>{{ $sale->customer_name }}</td>
                            <td>₹{{ number_format($sale->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No sales yet</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection