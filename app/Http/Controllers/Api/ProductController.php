<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category');

        // Filter by category
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Search by name or SKU
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filter by stock availability
        if ($request->has('in_stock')) {
            $query->where('stock_qty', '>', 0);
        }

        $products = $query->paginate($request->get('per_page', 15));

        return response()->json($products);
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'required|numeric|min:0',
            'stock_qty' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|url',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product->load('category')
        ], 201);
    }

    /**
     * Display the specified product
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product->load('category'));
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'price' => 'sometimes|numeric|min:0',
            'stock_qty' => 'sometimes|integer|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'image_url' => 'nullable|url',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product->load('category')
        ]);
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
