<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeViewController;
use App\Http\Controllers\Api\HighlightController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Public Auth Routes ---
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// --- Public Content Routes (for your website frontend) ---
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'showBySlug']);
Route::get('/highlights', [HighlightController::class, 'index']);
Route::get('/highlights/{slug}', [HighlightController::class, 'showBySlug']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/banners', [BannerController::class, 'index']);

// Comments, Likes, Views (Public interaction)
Route::post('/news/{id}/comments', [CommentController::class, 'store']);
Route::post('/news/{id}/like', [LikeViewController::class, 'storeLike']);
Route::post('/news/{id}/view', [LikeViewController::class, 'storeView']);

// --- Admin Protected Routes (for your dashboard) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::patch('/user/profile', [UserController::class, 'updateProfile']); // User updates self

    // User Management (Admin Only)
    Route::apiResource('/users', UserController::class)->only(['index', 'update']);

    // Full CRUD for Admin
    Route::apiResource('/admin/news', NewsController::class)->parameters(['news' => 'news']);
    Route::apiResource('/admin/highlights', HighlightController::class);
    Route::apiResource('/admin/categories', CategoryController::class)->parameters(['categories' => 'category']);
    Route::apiResource('/admin/tags', TagController::class)->parameters(['tags' => 'tag']);
    Route::apiResource('/admin/banners', BannerController::class);
    
    // Comment Management (Admin)
    Route::get('/admin/comments', [CommentController::class, 'index']);
    Route::delete('/admin/comments/{comment}', [CommentController::class, 'destroy']);
    
    // Stats (Admin)
    Route::get('/admin/stats/news/{id}/likes', [LikeViewController::class, 'getLikesForNews']);
    Route::get('/admin/stats/news/{id}/views', [LikeViewController::class, 'getViewsForNews']);
});