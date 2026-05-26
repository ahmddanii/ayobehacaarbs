<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Categories\Index as AdminCategories;
use App\Livewire\Admin\Articles\Index as AdminArticles;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Panel Admin (Dilindungi Auth)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/categories', AdminCategories::class)->name('categories');
    Route::get('/articles', AdminArticles::class)->name('articles');
});

// Profil Pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

