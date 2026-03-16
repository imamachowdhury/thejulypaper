<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ArticleController;

Route::get('/', [ArticleController::class, 'index'])->name('home');
Route::get('/category/{slug}', [ArticleController::class, 'category'])->name('category.show');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/search', [ArticleController::class, 'search'])->name('search');

Route::get('/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('page.show');

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);


