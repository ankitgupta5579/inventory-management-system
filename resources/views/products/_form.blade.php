{{-- $product is only set when editing. "?? null" avoids errors on create. --}}
@php $product = $product ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Product Name</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">SKU / Code</label>
        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select" required>
            <option value="">-- Select --</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Supplier</label>
        <select name="supplier_id" class="form-select">
            <option value="">-- Select --</option>
            @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}"
                    {{ old('supplier_id', $product->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                    {{ $supplier->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label class="form-label">Purchase Price</label>
        <input type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Selling Price</label>
        <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price', $product->selling_price ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Opening Stock</label>
        <input type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? 0) }}" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Reorder Level</label>
        <input type="number" name="reorder_level" value="{{ old('reorder_level', $product->reorder_level ?? 10) }}" class="form-control" required>
    </div>
    <div class="col-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
</div>