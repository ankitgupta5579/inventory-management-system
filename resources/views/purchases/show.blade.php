@extends('layouts.app')
@section('title', 'Purchase #' . $purchase->id)

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
            <h4 class="mb-0">Purchase Order #{{ $purchase->id }}</h4>
            <small class="text-muted">{{ $purchase->purchase_date->format('d M Y') }}</small>
        </div>
        <div class="text-end">
            <span class="badge bg-success">{{ ucfirst($purchase->status ?? 'received') }}</span>
        </div>
    </div>

    <p class="mb-1"><strong>Supplier:</strong> {{ $purchase->supplier->name ?? '-' }}</p>
    <p class="mb-4"><strong>Recorded by:</strong> {{ $purchase->user->name ?? '-' }}</p>

    <table class="table">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Price</th>
                <th class="text-end">Amount</th>
            </tr>
        </thead>
        <tbody>
        @foreach($purchase->items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->product->name ?? '-' }}</td>
                <td class="text-end">{{ $item->quantity }}</td>
                <td class="text-end">₹{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-end">₹{{ number_format($item->subtotal, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Grand Total</th>
                <th class="text-end">₹{{ number_format($purchase->total, 2) }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="no-print">
        <button onclick="window.print()" class="btn btn-primary"><i class="bi bi-printer"></i> Print</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
