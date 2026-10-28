@extends('layouts.app')
@section('title', 'Sales & Billing')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between">
        <h6 class="mb-0 pt-2">All Invoices</h6>
        <a href="{{ route('sales.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New Sale</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Invoice</th><th>Date</th><th>Customer</th><th>Total</th></tr></thead>
            <tbody>
            @forelse($sales as $sale)
                <tr>
                    <td>#{{ $sale->id }}</td>
                    <td>{{ $sale->created_at->format('d M Y') }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>₹{{ number_format($sale->total, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No sales yet</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">{{ $sales->links() }}</div>
</div>
@endsection