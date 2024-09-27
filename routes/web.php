<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\Auth\LikeController;
use App\Http\Controllers\Auth\CommentController;

Route::resource('categories', CategoryController::class);
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

Route::resource('users', UserController::class);
Route::resource('posts', PostController::class);
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Лайки
//Route::post('posts/{post}/like', [PostController::class, 'likePost'])->name('posts.like');
//Route::delete('posts/{post}/unlike', [PostController::class, 'unlikePost'])->name('posts.unlike');

// Коментарі
//Route::post('posts/{post}/comments', [PostController::class, 'storeComment'])->name('posts.comments.store');
//Route::delete('comments/{comment}', [PostController::class, 'destroyComment'])->name('comments.destroy');

Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('likes.store');
Route::delete('/likes/{like}', [LikeController::class, 'destroy'])->name('likes.destroy');
Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

Route::post('/posts/{post}/like', [LikeController::class, 'toggleLike'])->name('posts.toggleLike');


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

