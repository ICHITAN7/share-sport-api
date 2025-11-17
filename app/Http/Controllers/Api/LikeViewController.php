<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeViewController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['getViewsForNews','getViewsForHighlight']);
    }


    /**
     * PUBLIC: Store a view for a news article.
     */
    public function storeViewForNews(Request $request,News $news)
    {
        $news->views()->create(['user_ip' => $request->ip()]);

        return response()->json(['views' => $news->views()->count()], 200);
    }
    public function storeViewForHighlight(Request $request,Highlight $highlight)
    {
        $highlight->views()->create(['user_ip' => $request->ip()]);

        return response()->json(['views' => $highlight->views()->count()], 200);
    }

    public function getViewsForNews(Request $request, News $news)
    {
        $this->authorize('update', $news);
        $viewCount = $news->views()->count();
        return response()->json(['viewCount' => $viewCount,'view'=>$news->views()->get()], 200);
    }
    public function getViewsForHighlight(Request $request,Highlight $highlight)
    {
        $this->authorize('update', $highlight);
        $viewCount = $highlight->views()->count();
        return response()->json(['viewCount' => $viewCount,'view'=>$highlight->views()->get()], 200);
    }
}
