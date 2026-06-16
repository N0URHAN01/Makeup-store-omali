<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // All Products Page
    public function index()
    {
        $products = Product::with('category' , 'variants')
            ->latest()
            ->paginate(24);

        return view('customer.products.index', compact('products'));
    }

    // Product Details Page
    public function show(Product $product)
    {
        $product->load(['images', 'category' , 'variants']);

        return view('customer.products.show', compact('product'));
    }

     public function variants($id)
{
    $variants = ProductVariant::where('product_id', $id)
        ->select('id', 'color_name')
        ->get();

    return response()->json([
        'success' => true,
        'variants' => $variants
    ]);
}


public function search(Request $request)
{
    $keyword = trim($request->search ?? '');

    $products = collect();

    if ($keyword !== '') {
        $products = Product::with('category', 'variants')
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('product_code', 'like', "%{$keyword}%")
                    ->orWhereHas('category', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    });
            })
            ->latest()
            ->paginate(24)
            ->withQueryString();
    }

    return view('customer.products.search', compact('products', 'keyword'));
}
}


