@extends('layouts.app')
@section('title', 'Invoice #' . $sale->id)

@section('content')
<style>
    @media print {
        .sidebar, .top-navbar, .no-print { display: none !important; }
        .main-content { margin-left: 0 !important; }
    }
</style>

<div class="card p-4" style="max-width: 800px;">
    <div class="d-flex justify-content-between mb-4">
        <div>
            <h4 class="mb-0">InventoryPro</h4>
            <small class="text-muted">Tax Invoice</small>
        </div>
        <div class="text-end">
            <h5 class="mb-0">Invoice #{{ $sale->id }}</h5>
            <small>{{ $sale->sale_date->format('d M Y') }}</small>
        </div>
    </div>

    <p class="mb-1"><strong>Customer:</strong> {{ $sale->customer_name }}</p>
    <p class="mb-4"><strong>Billed by:</strong> {{ $sale->user->name }}</p>

    <table class="table">
        <thead class="table-light">
            <tr>
                <th>#</th><th>Product</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Price</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sale->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product->name }}</td>
                <td class="text-end">{{ $item->quantity }}</td>
                <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Grand Total</th>
                <th class="text-end">₹{{ number_format($sale->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
