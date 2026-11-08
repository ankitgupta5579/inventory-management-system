<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'totalProducts'    => 0,
            'totalSuppliers'   => 0,
            'todaySales'       => 0,
            'lowStockCount'    => 0,
            'lowStockProducts' => collect(),
            'recentSales'      => collect(),
        ]);
    }
}
