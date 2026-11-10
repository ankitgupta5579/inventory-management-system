<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        // Categories, keyed by name so products can find them
        $categories = collect(['Electronics', 'Accessories', 'Stationery'])
            ->mapWithKeys(fn ($name) => [
                $name => Category::firstOrCreate(['name' => $name]),
            ]);

        // Suppliers, keyed by name
        $suppliers = collect([
            'Sharma Traders' => [
                'phone' => '9800000001', 'email' => 'sharma@example.com',
                'address' => 'Howrah, West Bengal',
            ],
            'Kolkata Electronics Hub' => [
                'phone' => '9800000002', 'email' => 'hub@example.com',
                'address' => 'Kolkata, West Bengal',
            ],
            'Bengal Office Supplies' => [
                'phone' => '9800000003', 'email' => 'office@example.com',
                'address' => 'Salt Lake, Kolkata',
            ],
        ])->map(fn ($details, $name) => Supplier::firstOrCreate(['name' => $name], $details));

        // sku, name, category, supplier, purchase price, selling price, stock, reorder level
        $products = [
            ['ELE-001', 'Wireless Mouse',        'Electronics', 'Kolkata Electronics Hub', 250,  399,  40, 10],
            ['ELE-002', 'USB Keyboard',          'Electronics', 'Kolkata Electronics Hub', 450,  699,  25, 10],
            ['ELE-003', 'Bluetooth Speaker',     'Electronics', 'Kolkata Electronics Hub', 1200, 1799, 4,  8],   // low stock
            ['ACC-001', 'Phone Cover',           'Accessories', 'Sharma Traders',          80,   199,  60, 15],
            ['ACC-002', 'USB-C Cable',           'Accessories', 'Sharma Traders',          120,  249,  6,  10],  // low stock
            ['STA-001', 'A4 Notebook',           'Stationery',  'Bengal Office Supplies',  35,   60,   100, 20],
            ['STA-002', 'Ball Pen (Pack of 10)', 'Stationery',  'Bengal Office Supplies',  40,   80,   50, 15],
            ['STA-003', 'Marker Set',            'Stationery',  'Bengal Office Supplies',  90,   160,  18, 10],
        ];

        foreach ($products as [$sku, $name, $category, $supplier, $cost, $price, $qty, $reorder]) {
            $product = Product::firstOrCreate(['sku' => $sku], [
                'name' => $name,
                'category_id' => $categories[$category]->id,
                'supplier_id' => $suppliers[$supplier]->id,
                'purchase_price' => $cost,
                'selling_price' => $price,
                'quantity' => $qty,
                'reorder_level' => $reorder,
            ]);

            // Opening stock is also a stock movement, so history adds up
            if ($product->wasRecentlyCreated) {
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'opening',
                    'quantity' => $qty,
                ]);
            }
        }
    }
}
