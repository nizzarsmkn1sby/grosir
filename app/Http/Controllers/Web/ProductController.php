<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('stock_qty', '>', 0);

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12);
        $categories = Category::whereNull('parent_id')->with('children')->get();

        if ($request->ajax()) {
            return view('products.partials.product-list', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock_qty', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('stock_qty', '>', 0)
            ->with('category')
            ->paginate(12);
        
        $categories = Category::whereNull('parent_id')->with('children')->get();

        if (request()->ajax()) {
            return view('products.partials.product-list', compact('products'))->render();
        }

        return view('products.index', compact('products', 'categories', 'category'));
    }
}
