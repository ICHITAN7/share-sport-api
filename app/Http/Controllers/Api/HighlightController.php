<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHighlightRequest;
use App\Http\Requests\UpdateHighlightRequest;
use App\Models\Highlight;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HighlightController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'showBySlug']);
    }

    public function index()
    {
        return Highlight::with(['author','category'])
                ->where('is_published', true)
                // ->where(function($query) {
                // $query->where('published_at', '<=', now())
                //       ->orWhereNull('published_at');
                // })
                ->latest('published_at')
                ->paginate(20);
    }

    public function showBySlug($slug)
    {
        $highlight = Highlight::with(['category', 'author'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
        return $highlight;
    }

    // Create highlight
    public function store(StoreHighlightRequest $request)
    {
        $this->authorize('create', Highlight::class);
        $validated = $request->validated();

        $validated['author_id'] = $request->user()->id;

        $highlight = Highlight::create($validated);

        return response()->json($highlight->load(['category', 'author']), 201);
    }

    public function show(Highlight $highlight)
    {
        $this->authorize('update', $highlight);
        return $highlight->load(['category','author']);
    }

    // Update highlight
    public function update(UpdateHighlightRequest $request, Highlight $highlight)
    {
        $this->authorize('update', $highlight);
        $validated = $request->validated();
        $highlight->update($validated);

        return response()->json($highlight->load(['author','category']));
    }

    // Delete highlight
    public function destroy(Highlight $highlight)
    {
        $this->authorize('delete', $highlight);
        $highlight->delete();
        return response()->json(null,204);
    }
}
