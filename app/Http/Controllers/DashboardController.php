<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        // Temporary values so the page loads.
        // Later, replace these with real database queries.
        return view('dashboard.index', [
            'totalProducts'    => 0,
            'totalSuppliers'   => 0,
            'todaySales'       => 0,
            'lowStockCount'    => 0,
            'lowStockProducts' => collect(),   // empty list
            'recentSales'      => collect(),   // empty list
        ]);
    }
}