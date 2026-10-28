@extends('layouts.app')
@section('title', 'New Purchase Order')

@section('content')
<form action="{{ route('purchases.store') }}" method="POST" class="card p-4">
    @csrf

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <label class="form-label">Supplier</label>
            <select name="supplier_id" class="form-select" required>
                <option value="">-- Select Supplier --</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Date</label>
            <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-control" required>
        </div>
    </div>

    {{-- Items table: rows are added with JavaScript --}}
    <table class="table align-middle">
        <thead class="table-light">
            <tr><th>Product</th><th width="120">Qty</th><th width="150">Cost Price</th><th width="120">Subtotal</th><th width="50"></th></tr>
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
        <button class="btn btn-success"><i class="bi bi-check-lg"></i> Save Purchase</button>
        <a href="{{ route('purchases.index') }}" class="btn btn-secondary">Cancel</a>
    </div>
</form>

{{-- Hidden row template that addRow() copies --}}
<template id="row-template">
    <tr>
        <td>
            <select name="product_id[]" class="form-select" onchange="fillPrice(this)" required>
                <option value="">-- Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">{{ $product->name }}</option>
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
<script> addRow(); // start with one empty row </script>
@endpush