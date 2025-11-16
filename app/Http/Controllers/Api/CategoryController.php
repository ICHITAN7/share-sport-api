<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // Public index, admin for everything else
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        return Category::orderBy('name')->get();
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', \App\Models\News::class); // Only writers+ can make categories
        $category = Category::create($request->validated());
        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100|unique:categories,name,' . $category->id,
            'slug' => 'sometimes|string|max:120|unique:categories,slug,' . $category->id,
            'icon_url' => 'nullable|url',
        ]);

        $category->update($validated);
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', \App\Models\News::class); // Only writers+
        
        // Add logic here to prevent deletion if category has news items
        if ($category->news()->count() > 0) {
            return response()->json(['message' => 'Cannot delete category with associated news.'], 409);
        }
        
        $category->delete();
        return response()->json(null, 204);
    }
}