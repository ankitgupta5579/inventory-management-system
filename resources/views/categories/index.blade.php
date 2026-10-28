@extends('layouts.app')
@section('title', 'Categories')

@section('content')
<div class="row g-3">
    {{-- Add form --}}
    <div class="col-md-4">
        <div class="card p-3">
            <h6 class="fw-bold">Add Category</h6>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <input type="text" name="name" class="form-control mb-2" placeholder="Category name" required>
                <textarea name="description" class="form-control mb-2" rows="2" placeholder="Description (optional)"></textarea>
                <button class="btn btn-primary w-100">Add</button>
            </form>
        </div>
    </div>

    {{-- List --}}
    <div class="col-md-8">
        <div class="card">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light"><tr><th>#</th><th>Name</th><th>Products</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td><span class="badge bg-secondary">{{ $category->products_count ?? 0 }}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#edit{{ $category->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this category?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>

                    {{-- Edit modal (one per category) --}}
                    <div class="modal fade" id="edit{{ $category->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('categories.update', $category) }}" method="POST" class="modal-content">
                                @csrf @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" name="name" value="{{ $category->name }}" class="form-control mb-2" required>
                                    <textarea name="description" class="form-control" rows="2">{{ $category->description }}</textarea>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No categories yet</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection