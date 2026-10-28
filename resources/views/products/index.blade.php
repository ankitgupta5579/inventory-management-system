@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        {{-- Search form (sends ?search=... to the controller) --}}
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search product...">
            <button class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
        </form>
        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Add Product</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>#</th><th>Name</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->sku }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>₹{{ number_format($product->selling_price, 2) }}</td>
                    <td>
                        {{-- Red badge if stock is low, green otherwise --}}
                        <span class="badge {{ $product->quantity <= $product->reorder_level ? 'bg-danger' : 'bg-success' }}">
                            {{ $product->quantity }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No products found</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white">{{ $products->links() }}</div>
</div>
@endsection