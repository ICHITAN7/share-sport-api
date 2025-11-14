<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\HighlightController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
//search Routes
Route::get('/user/{user}',[UserController::class,'find'])->name('api.users.find');

// --- Public Authentication Routes ---
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// --- Public Read-Only Routes ---
Route::get('articles', [ArticleController::class, 'index'])->name('api.articles.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('api.articles.show');
Route::get('highlights', [HighlightController::class, 'index'])->name('api.highlights.index');
Route::get('highlights/{highlight}', [HighlightController::class, 'show'])->name('api.highlights.show');

Route::middleware('auth:sanctum')->group(function () {
    
    // Auth routes
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    // Route::patch('/update', [AuthController::class, 'update'])->name('api.update');
    Route::patch('/updateprofile', [AuthController::class, 'updateProfile'])->name('api.update');

    // Article Admin Routes
    Route::post('articles', [ArticleController::class, 'store'])->name('api.articles.store');
    Route::put('articles/{article}', [ArticleController::class, 'update'])->name('api.articles.update');
    Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('api.articles.patch');
    Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('api.articles.destroy');

    // Highlight Admin Routes
    Route::post('highlights', [HighlightController::class, 'store'])->name('api.highlights.store');
    Route::put('highlights/{highlight}', [HighlightController::class, 'update'])->name('api.highlights.update');
    Route::patch('highlights/{highlight}', [HighlightController::class, 'update'])->name('api.highlights.patch');
    Route::delete('highlights/{highlight}', [HighlightController::class, 'destroy'])->name('api.highlights.destroy');
});