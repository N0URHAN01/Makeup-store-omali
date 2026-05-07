<?php

namespace App\Http\Controllers\Customer;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
      public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->take(14)
            ->get();

              $featuredProducts = Product::latest()
        ->take(15)
        ->get();



        $offersCategory = Category::whereRaw('LOWER(name) = ?', ['offers'])->first();

    $offerProducts = collect();

    if ($offersCategory) {
        $categoryIds = collect([$offersCategory->id])
            ->merge($offersCategory->children->pluck('id'));

        $offerProducts = Product::whereIn('category_id', $categoryIds)
            ->latest()
            ->take(10)
            ->get();
    }
        
        return view('customer.home.index', compact('categories', 'featuredProducts', 'offerProducts',  'offersCategory'));
    }
}
