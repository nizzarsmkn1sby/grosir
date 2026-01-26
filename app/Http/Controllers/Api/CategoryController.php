<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(Request $request): JsonResponse
    {
        $query = Category::with(['parent', 'children']);

        // Get only parent categories
        if ($request->has('parent_only')) {
            $query->whereNull('parent_id');
        }

        // Get only child categories
        if ($request->has('children_only')) {
            $query->whereNotNull('parent_id');
        }

        $categories = $query->get();

        return response()->json($categories);
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category->load(['parent', 'children'])
        ], 201);
    }

    /**
     * Display the specified category
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json($category->load(['parent', 'children', 'products']));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category->load(['parent', 'children'])
        ]);
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
