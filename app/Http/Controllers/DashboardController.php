<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalProducts'    => Product::count(),
            'totalSuppliers'   => Supplier::count(),
            'todaySales'       => 0,                 // real value after Sales
            'lowStockCount'    => Product::lowStock()->count(),
            'lowStockProducts' => Product::lowStock()->orderBy('quantity')->take(5)->get(),
            'recentSales'      => collect(),         // real value after Sales
        ]);
    }
}
