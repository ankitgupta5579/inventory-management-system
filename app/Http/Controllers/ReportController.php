<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => 'nullable|in:sales,purchases,stock',
            'from' => 'nullable|date',
            'to'   => 'nullable|date|after_or_equal:from',
        ]);

        $from = $request->from;
        $to   = $request->to;

        // Reusable date filter: applies From/To to any query on any date column
        $range = fn ($query, $column) => $query
            ->when($from, fn ($q) => $q->whereDate($column, '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate($column, '<=', $to));

        // Summary cards (the database does the adding)
        $totalSales     = $range(Sale::query(), 'sale_date')->sum('total');
        $totalPurchases = $range(Purchase::query(), 'purchase_date')->sum('total');

        // Cost of the goods that were sold = quantity sold x product cost price
        $costOfGoodsSold = DB::table('sale_items')
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->when($from, fn ($q) => $q->whereDate('sales.sale_date', '>=', $from))
            ->when($to,   fn ($q) => $q->whereDate('sales.sale_date', '<=', $to))
            ->sum(DB::raw('sale_items.quantity * products.purchase_price'));

        $profit = $totalSales - $costOfGoodsSold;

        // Detail table: only after the user picks a report type
        $reportRows = collect();

        if ($request->filled('type')) {
            $reportRows = match ($request->type) {
                'sales' => $range(Sale::query(), 'sale_date')
                    ->latest('sale_date')->get()
                    ->map(fn ($s) => (object) [
                        'date'        => $s->sale_date->format('d M Y'),
                        'reference'   => 'INV-' . $s->id,
                        'description' => $s->customer_name,
                        'amount'      => $s->total,
                    ]),

                'purchases' => $range(Purchase::with('supplier'), 'purchase_date')
                    ->latest('purchase_date')->get()
                    ->map(fn ($p) => (object) [
                        'date'        => $p->purchase_date->format('d M Y'),
                        'reference'   => 'PO-' . $p->id,
                        'description' => $p->supplier->name ?? '-',
                        'amount'      => $p->total,
                    ]),

                'stock' => Product::orderBy('name')->get()
                    ->map(fn ($p) => (object) [
                        'date'        => $p->updated_at->format('d M Y'),
                        'reference'   => $p->sku,
                        'description' => "{$p->name} ({$p->quantity} in stock)",
                        'amount'      => $p->quantity * $p->purchase_price,
                    ]),
            };
        }

        return view('reports.index', compact(
            'totalSales', 'totalPurchases', 'profit', 'reportRows'
        ));
    }
}
