<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();
        
        $featuredProducts = Product::with('category')
            ->where('stock_qty', '>', 0)
            ->latest()
            ->take(12)
            ->get();
        
        $newArrivals = Product::with('category')
            ->where('stock_qty', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'newArrivals'));
    }
}
