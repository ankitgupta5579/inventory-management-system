@extends('layouts.app')
@section('title', 'Reports & Analysis')

@section('content')
{{-- Filter --}}
<form method="GET" class="card p-3 mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Report Type</label>
            <select name="type" class="form-select">
                <option value="sales"     {{ request('type') == 'sales' ? 'selected' : '' }}>Sales Report</option>
                <option value="purchases" {{ request('type') == 'purchases' ? 'selected' : '' }}>Purchase Report</option>
                <option value="stock"     {{ request('type') == 'stock' ? 'selected' : '' }}>Stock Report</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <label class="form-label">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary"><i class="bi bi-funnel"></i> Generate</button>
            <button type="button" class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
        </div>
    </div>
</form>

{{-- Summary --}}
<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="card p-3"><div class="text-muted small">Total Sales</div><h4>₹{{ number_format($totalSales ?? 0, 2) }}</h4></div></div>
    <div class="col-md-4"><div class="card p-3"><div class="text-muted small">Total Purchases</div><h4>₹{{ number_format($totalPurchases ?? 0, 2) }}</h4></div></div>
    <div class="col-md-4"><div class="card p-3"><div class="text-muted small">Profit</div><h4 class="text-success">₹{{ number_format($profit ?? 0, 2) }}</h4></div></div>
</div>

{{-- Result table --}}
<div class="card">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead class="table-light"><tr><th>Date</th><th>Reference</th><th>Description</th><th class="text-end">Amount</th></tr></thead>
            <tbody>
            @forelse($reportRows ?? [] as $row)
                <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->reference }}</td>
                    <td>{{ $row->description }}</td>
                    <td class="text-end">₹{{ number_format($row->amount, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Select filters and click Generate</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection