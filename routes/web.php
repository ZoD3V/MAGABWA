<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama
Route::get('/', [FrontController::class, 'index'])->name('front.index');

// Route untuk detail artikel
Route::get('/details/{article_news:slug}', [FrontController::class, 'details'])->name('front.details');

// Route untuk kategori
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');

// Route untuk penulis
Route::get('/author/{author:slug}', [FrontController::class, 'author'])->name('front.author');

// Route untuk pencarian
Route::get('/search', [FrontController::class, 'search'])->name('front.search');