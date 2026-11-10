<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        return view('sales.index', [
            'sales' => Sale::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('sales.create', [
            'products' => Product::where('quantity', '>', 0)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $lines = count((array) $request->product_id);

        $data = $request->validate([
            'customer_name' => 'required|string|max:100',
            'date' => 'required|date',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => "required|array|size:$lines",
            'quantity.*' => 'required|integer|min:1',
            'price' => "required|array|size:$lines",
            'price.*' => 'required|numeric|min:0',
        ]);

        $sale = DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_name' => $data['customer_name'],
                'sale_date' => $data['date'],
                'total' => 0,
            ]);

            $total = 0;

            foreach ($data['product_id'] as $i => $productId) {
                $qty = (int) $data['quantity'][$i];
                $price = (float) $data['price'][$i];

                // Lock this product row until the transaction ends
                $product = Product::lockForUpdate()->findOrFail($productId);

                // Refuse to oversell. Throwing here rolls back EVERYTHING.
                if ($product->quantity < $qty) {
                    throw ValidationException::withMessages([
                        'quantity' => "Not enough stock for {$product->name}. "
                                    ."Available: {$product->quantity}, requested: {$qty}.",
                    ]);
                }

                $subtotal = round($qty * $price, 2);
                $total += $subtotal;

                // 1. Save the line item
                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // 2. Decrease stock
                $product->decrement('quantity', $qty);

                // 3. Record the history (negative = stock out)
                StockMovement::create([
                    'product_id' => $product->id,
                    'user_id' => auth()->id(),
                    'type' => 'sale',
                    'quantity' => -$qty,
                    'reference_id' => $sale->id,
                ]);
            }

            // 4. Save the real total, calculated by the server
            $sale->update(['total' => $total]);

            return $sale;
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Bill generated.');
    }

    public function show(Sale $sale)
    {
        $sale->load('items.product', 'user');

        return view('sales.show', compact('sale'));
    }
}
