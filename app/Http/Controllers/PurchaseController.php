<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('purchases.index', [
            'purchases' => Purchase::with('supplier')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('purchases.create', [
            'suppliers' => Supplier::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('items.product', 'supplier', 'user');

        return view('purchases.show', compact('purchase'));
    }

    public function store(Request $request)
    {
        $lines = count((array) $request->product_id);

        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'date' => 'required|date',
            'product_id' => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'quantity' => "required|array|size:$lines",
            'quantity.*' => 'required|integer|min:1',
            'price' => "required|array|size:$lines",
            'price.*' => 'required|numeric|min:0',
        ]);

        $purchase = DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'supplier_id' => $data['supplier_id'],
                'user_id' => auth()->id(),
                'purchase_date' => $data['date'],
                'total' => 0,
                'status' => 'received',
            ]);

            $total = 0;

            foreach ($data['product_id'] as $i => $productId) {
                $qty = (int) $data['quantity'][$i];
                $price = (float) $data['price'][$i];
                $subtotal = round($qty * $price, 2);
                $total += $subtotal;

                // 1. Save the line item
                $purchase->items()->create([
                    'product_id' => $productId,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);

                // 2. Increase stock
                Product::whereKey($productId)->increment('quantity', $qty);

                // 3. Record the history
                StockMovement::create([
                    'product_id' => $productId,
                    'user_id' => auth()->id(),
                    'type' => 'purchase',
                    'quantity' => $qty,
                    'reference_id' => $purchase->id,
                ]);
            }

            // 4. Save the real total, calculated by the server
            $purchase->update(['total' => $total]);

            return $purchase;
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Purchase saved and stock updated.');
    }
}
