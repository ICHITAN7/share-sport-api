<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();

        return view('web.categories.index', [
            'categories' => $categories,
        ]);
        // Assumes view at: resources/views/web/categories/index.blade.php
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $news = $category->news()
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('web.categories.show', [
            'category' => $category,
            'news' => $news,
        ]);
        // Assumes view at: resources/views/web/categories/show.blade.php
    }
}
