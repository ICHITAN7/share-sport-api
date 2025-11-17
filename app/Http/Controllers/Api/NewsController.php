<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class NewsController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // Apply auth middleware to all admin methods
        $this->middleware('auth:sanctum')->except(['index', 'showBySlug']);
    }

    /**
     * PUBLIC: Display a listing of published news.
     */
    public function index()
    {
        return News::with(['category', 'author', 'tags'])
            ->withCount('views')
            ->where('is_published', true)
            ->where(function($query) {
                $query->where('published_at', '<=', now())
                      ->orWhereNull('published_at');
            })
            ->latest('published_at')
            ->paginate(20);
    }

    /**
     * PUBLIC: Display a single news item by its slug.
     */
    public function showBySlug($slug)
    {
        $news = News::with(['category', 'author', 'tags'])
            ->withCount('views')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return $news;
    }

    // --- ADMIN METHODS ---

    /**
     * ADMIN: Store a newly created resource in storage.
     */
    public function store(StoreNewsRequest $request)
    {
        $this->authorize('create', News::class);

        $validated = $request->validated();

        // Set author_id from the logged-in user
        $validated['author_id'] = $request->user()->id;

        // Create the news post
        $news = News::create($validated);

        // Attach tags if they exist
        if (!empty($validated['tags'])) {
            $news->tags()->attach($validated['tags']);
        }

        return response()->json($news->load(['category', 'author', 'tags']), 201);
    }

    /**
     * ADMIN: Display the specified resource by ID.
     */
    public function show(News $news)
    {
        $this->authorize('update', $news); // Check if user can view/update
        return $news->load(['category', 'author', 'tags', 'comments', 'likes', 'views']);
    }

    /**
     * ADMIN: Update the specified resource in storage.
     */
    public function update(UpdateNewsRequest $request, News $news)
    {
        $this->authorize('update', $news);

        $validated = $request->validated();

        $news->update($validated);

        // Sync tags if they are part of the request
        if ($request->has('tags')) {
            $news->tags()->sync($validated['tags'] ?? []);
        }

        return response()->json($news->load(['category', 'author', 'tags']));
    }

    /**
     * ADMIN: Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        $this->authorize('delete', $news);

        // Tags will be detached automatically due to DB cascade
        $news->delete();

        return response()->json(null, 204);
    }
}
