<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Like;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LikeViewController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // Require authentication only for these methods
        $this->middleware('auth:sanctum')->only([
            'getLikesForNews', 
            'getViewsForNews'
        ]);
    }

    /**
     * PUBLIC: Store a like for a news article.
     */
    public function storeLike(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);
        $ip = $request->ip();

        // Use firstOrCreate to prevent duplicate likes from a single IP
        $like = $news->likes()->firstOrCreate(
            ['user_ip' => $ip],
            []
        );

        if ($like->wasRecentlyCreated) {
            return response()->json(['message' => 'Liked!'], 201);
        } else {
            return response()->json(['message' => 'Already liked.'], 200);
        }
    }

    /**
     * PUBLIC: Store a view for a news article.
     */
    public function storeView(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);
        
        // We don't check for uniqueness here, just log the view.
        // Your frontend should have logic to prevent spamming this.
        $news->views()->create([
            'user_ip' => $request->ip()
        ]);

        return response()->json(null, 204);
    }

    /**
     * ADMIN: Get like count for a news article.
     */
    public function getLikesForNews($newsId)
    {
        $this->authorize('update', \App\Models\News::class); //Admin
        $count = Like::where('news_id', $newsId)->count();
        return response()->json(['news_id' => $newsId, 'like_count' => $count]);
    }

    /**
     * ADMIN: Get view count for a news article.
     */
    public function getViewsForNews(Request $request, $newsId)
    {
        // Find the news item, or fail with 404
        $news = News::findOrFail($newsId);

        // Authorize: only admin can access
        $this->authorize('update', $news);

        // Count views
        $viewCount = View::where('news_id', $newsId)->count();

        // Return JSON response
        return response()->json([
            'news_id'    => $newsId,
            'title'      => $news->title,
            'view_count' => $viewCount
        ]);
    }
}