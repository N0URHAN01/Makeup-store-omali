<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductController extends Controller
{
    // All Products Page
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(12);

        return view('customer.products.index', compact('products'));
    }

    // Product Details Page
    public function show(Product $product)
    {
        $product->load(['images', 'category']);

        return view('customer.products.show', compact('product'));
    }
}
