<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalProducts'    => Product::count(),
            'totalSuppliers'   => Supplier::count(),
            'todaySales'  => Sale::whereDate('sale_date', today())->sum('total'),               // real value after Sales
            'lowStockCount'    => Product::lowStock()->count(),
            'lowStockProducts' => Product::lowStock()->orderBy('quantity')->take(5)->get(),
            'recentSales' => Sale::latest()->take(5)->get(),         // real value after Sales
        ]);
    }
}
