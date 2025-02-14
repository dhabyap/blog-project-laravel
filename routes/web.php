<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;


Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/category/{slug}', [PostController::class, 'filterByCategory'])->name('posts.category');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');



Route::middleware(['auth'])->group(function () {
    Route::resource('/dashboard', DashboardController::class)->except(['show'])->parameters([
        'dashboard' => 'post'
    ]);
    Route::get('/dashboard/{post}', [DashboardController::class, 'show'])->name('dashboard.show');
});