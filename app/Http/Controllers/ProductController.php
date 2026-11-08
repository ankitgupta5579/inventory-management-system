<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::orderBy('name')->get(),
            'suppliers'  => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Product::create($request->validate($this->rules()));

        return redirect()->route('products.index')
            ->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'suppliers'  => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $product->update($request->validate($this->rules($product->id)));

        return redirect()->route('products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete(); // soft delete

        return back()->with('success', 'Product deleted.');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'name'           => 'required|string|max:150',
            'sku'            => ['required', 'string', 'max:50',
                                 Rule::unique('products', 'sku')->ignore($ignoreId)],
            'description'    => 'nullable|string|max:1000',
            'category_id'    => 'required|exists:categories,id',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'quantity'       => 'required|integer|min:0',
            'reorder_level'  => 'required|integer|min:0',
        ];
    }
}
