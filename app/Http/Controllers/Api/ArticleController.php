<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Http\Requests\store_article_requests;
use App\Http\Requests\update_article_requests;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return Article::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(store_article_requests $request)
    {
        $user = $request->user(); 
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $article = Article::create(array_merge(
                $request->validated(),
                [
                    'user_id' => $user->id,
                ]
            ));
        return response()->json($article, 201); // 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return $article;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update_article_requests $request, Article $article)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if($user->rule!='manager'){
            if ($article->user_id !== $user->id) { 
            return response()->json(['message' => 'Forbidden: You do not own this article'], 403);
        }
        }
        $article->update($request->validated());
        return response()->json($article, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article ,Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($article->user_id !== $user->id) { 
            return response()->json(['message' => 'Forbidden: You do not own this article'], 403);
        }
        $article->delete();
        return response()->json(['message' => 'Article deleted'], 200);
    }
}