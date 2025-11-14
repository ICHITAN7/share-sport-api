<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use App\Http\Requests\Store_highlight_requests;
use App\Http\Requests\update_highlight_requests;
use Illuminate\Http\Request;

class HighlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Highlight::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Store_highlight_requests $request)
    {
        $user = $request->user(); 
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        $highlight = Highlight::create(array_merge(
            $request->validated(),
            [
                'user_id' => $user->id,
            ]
        ));

        return response()->json($highlight, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Highlight $highlight)
    {
        return $highlight;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(update_highlight_requests $request, Highlight $highlight)
    {
        $user = $request->user(); 
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        if ($highlight->user_id !== $user->id) { 
            return response()->json(['message' => 'Forbidden: You do not own this highlight'], 403);
        }

        $highlight->update($request->validated());

        return response()->json($highlight);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Highlight $highlight,  Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($highlight->user_id !== $user->id) { 
            return response()->json(['message' => 'Forbidden: You do not own this highlight'], 403);
        }
        $highlight->delete();

        return response()->json(['message' => 'Highlight deleted'], 200);
    }
}