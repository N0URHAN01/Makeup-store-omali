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
            ->get();

        return view('customer.home.index', compact('categories'));
    }
}
