<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Dashboard stats
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('total_price');
        $lowStock = Product::where('stock', '<=', 5)->count();
        $activeDiscounts = Product::where('discount_percentage', '>', 0)->count();

        $latestOrders = Order::latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->take(6)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'lowStock',
            'activeDiscounts',
            'latestOrders',
            'lowStockProducts'
        ));
    }
}
