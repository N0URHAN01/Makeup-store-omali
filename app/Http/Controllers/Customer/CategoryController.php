<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{

    public function index()
{
    $categories = Category::whereNull('parent_id')->with('children')->get();
    return view('customer.categories.index', compact('categories'));
}

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with('children')
            ->firstOrFail();

        // IDs: category + children
        $categoryIds = collect([$category->id])
            ->merge($category->children->pluck('id'));

        $products = Product::whereIn('category_id', $categoryIds)->get();

        return view('customer.categories.show', compact(
            'category',
            'products'
        ));
    }
}
