<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TagController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        return Tag::orderBy('name')->get();
    }

    public function store(StoreTagRequest $request)
    {
        $this->authorize('create', \App\Models\News::class); // Only writers+
        $tag = Tag::create($request->validated());
        return response()->json($tag, 201);
    }

    public function show(Tag $tag)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        return $tag;
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        
        $validated = $request->validate([
            'name' => 'sometimes|string|max:100|unique:tags,name,' . $tag->id,
            'slug' => 'sometimes|string|max:120|unique:tags,slug,' . $tag->id,
        ]);

        $tag->update($validated);
        return response()->json($tag);
    }

    public function destroy(Tag $tag)
    {
        $this->authorize('delete', \App\Models\News::class); // Only writers+
        // Tags can be deleted freely, pivot table will cascade
        $tag->delete();
        return response()->json(null, 204);
    }
}