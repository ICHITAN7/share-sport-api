<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\NewsController;
use App\Http\Controllers\Web\CategoryController;


// Welcome/Home Page
Route::get('/', [PageController::class, 'home'])->name('web.home');

// News Routes
Route::get('/news', [NewsController::class, 'index'])->name('web.news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('web.news.show');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('web.categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('web.categories.show');

// You can add other public pages here
// Route::get('/about', [PageController::class, 'about'])->name('web.about');
// Route::get('/contact', [PageController::class, 'contact'])->name('web.contact');

// Note: This assumes you have controllers in App\Http\Controllers\Web\
// that fetch data (e.g., from your database or API) and return
// Blade views using `return view(...)`.
