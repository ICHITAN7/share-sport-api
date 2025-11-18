<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News; // Assuming you have a News model

class NewsController extends Controller
{

    public function index()
    {
        $news = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(10); // Paginate with 10 items per page

        return view('web.news.index', [
            'news' => $news,
        ]);
        // Assumes view at: resources/views/web/news/index.blade.php
    }

    public function show($slug)
    {
        $newsItem = News::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail(); // Fails with 404 if not found

        // You might want to get related news as well
        $relatedNews = News::where('category_id', $newsItem->category_id)
            ->where('id', '!=', $newsItem->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('web.news.show', [
            'newsItem' => $newsItem,
            'relatedNews' => $relatedNews,
        ]);
        // Assumes view at: resources/views/web/news/show.blade.php
    }
}
