@extends('layouts.app')
@section('title', 'Purchase Orders')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between">
        <h6 class="mb-0 pt-2">Purchase Orders</h6>
        <a href="{{ route('purchases.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Purchase</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>PO #</th><th>Date</th><th>Supplier</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
            @forelse($purchases as $purchase)
                <tr>
                    <td>#{{ $purchase->id }}</td>
                    <td>{{ $purchase->created_at->format('d M Y') }}</td>
                    <td>{{ $purchase->supplier->name ?? '-' }}</td>
                    <td>₹{{ number_format($purchase->total, 2) }}</td>
                    <td><span class="badge bg-success">{{ ucfirst($purchase->status ?? 'received') }}</span></td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No purchases yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $purchases->links() }}</div>
</div>
@endsection