@extends('layouts.app')
@section('title', 'New Sale')

@section('content')
<form action="{{ route('sales.store') }}" method="POST" class="card p-4">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" placeholder="Walk-in customer" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control" required>
        </div>
    </div>

    <table class="table align-middle">
        <thead class="table-light">
            <tr><th>Product</th><th width="120">Qty</th><th width="150">Price</th><th width="120">Subtotal</th><th width="50"></th></tr>
        </thead>
        <tbody id="items-body"></tbody>
        <tfoot>
            <tr><td colspan="3" class="text-end fw-bold">Grand Total:</td>
                <td colspan="2" class="fw-bold">₹<span id="grand-total">0.00</span></td></tr>
        </tfoot>
    </table>

    <div>
        <button type="button" class="btn btn-outline-primary" onclick="addRow()"><i class="bi bi-plus"></i> Add Item</button>
    </div>

    <div class="mt-4">
        <button class="btn btn-success"><i class="bi bi-check-lg"></i> Generate Bill</button>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<template id="row-template">
    <tr>
        <td>
            <select name="product_id[]" class="form-select" onchange="fillPrice(this)" required>
                <option value="">-- Product --</option>
                @foreach($products as $product)
                    {{-- Shows available stock so the user can't oversell by mistake --}}
                    <option value="{{ $product->id }}" data-price="{{ $product->selling_price }}">
                        {{ $product->name }} (Stock: {{ $product->quantity }})
                    </option>
                @endforeach
            </select>
        </td>
        <td><input type="number" name="quantity[]" class="form-control qty" value="1" min="1" oninput="calculateTotal()"></td>
        <td><input type="number" step="0.01" name="price[]" class="form-control price" oninput="calculateTotal()"></td>
        <td>₹<span class="subtotal">0.00</span></td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i class="bi bi-x"></i></button></td>
    </tr>
</template>
@endsection

@push('scripts')
<script> addRow(); </script>
@endpush