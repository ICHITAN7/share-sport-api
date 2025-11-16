<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Http\Requests\StoreBannerRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BannerController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        // Banners are public to view, admin to manage
        $this->middleware('auth:sanctum')->except(['index']);
    }

    public function index()
    {
        // Public route only shows active banners
        return Banner::where('start_at', '<=', now())
            ->where(function ($q) {
                $q->where('end_at', '>=', now())
                  ->orWhereNull('end_at');
            })
            ->orderBy('position')
            ->get();
    }

    public function store(StoreBannerRequest $request)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        $banner = Banner::create($request->validated());
        return response()->json($banner, 201);
    }

    public function show(Banner $banner)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        return $banner;
    }

    public function update(StoreBannerRequest $request, Banner $banner)
    {
        $this->authorize('update', \App\Models\News::class); // Only writers+
        $banner->update($request->validated());
        return response()->json($banner);
    }

    public function destroy(Banner $banner)
    {
        $this->authorize('delete', \App\Models\News::class); // Only writers+
        $banner->delete();
        return response()->json(null, 204);
    }
}