<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Highlight;

class PageController extends Controller
{
    public function home()
    {
        // Example: Fetch recent news and highlights for the home page
        $recentNews = News::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(5)
            ->get();

        $highlights = Highlight::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Pass data to the Blade view
        return view('web.home', [
            'recentNews' => $recentNews,
            'highlights' => $highlights,
        ]);
        // This assumes you have a view at: resources/views/web/home.blade.php
    }

    public function about()
    {
        return view('web.about');
        // This assumes you have a view at: resources/views/web/about.blade.php
    }

    public function contact()
    {
        return view('web.contact');
        // This assumes you have a view at: resources/views/web/contact.blade.php
    }
}
