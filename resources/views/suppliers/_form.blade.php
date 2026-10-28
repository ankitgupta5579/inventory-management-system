@php $supplier = $supplier ?? null; @endphp

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Supplier Name</label>
        <input type="text" name="name" value="{{ old('name', $supplier->name ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $supplier->phone ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" value="{{ old('email', $supplier->email ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Address</label>
        <input type="text" name="address" value="{{ old('address', $supplier->address ?? '') }}" class="form-control">
    </div>
</div>
<div class="mt-4">
    <button class="btn btn-primary"><i class="bi bi-save"></i> Save</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
</div>