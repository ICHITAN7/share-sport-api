<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use App\Http\Requests\StoreCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CommentController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // Public to store, admin to manage
        $this->middleware('auth:sanctum')->only(['index', 'destroy']);
    }

    /**
     * ADMIN: List all comments.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); // Admin only
        return Comment::with('news:id,title')->latest()->paginate(50);
    }

    /**
     * PUBLIC: Store a new comment.
     */
    public function store(StoreCommentRequest $request, $newsId)
    {
        $news = News::findOrFail($newsId);
        $comment = $news->comments()->create($request->validated());
        return response()->json($comment, 201);
    }

    /**
     * ADMIN: Delete a comment.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', \App\Models\News::class); // Admin
        $comment->delete();
        return response()->json(null, 204);
    }
}