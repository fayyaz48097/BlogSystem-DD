<?php

use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BlogPostController::class, 'index']);

Route::resource('blog-posts', BlogPostController::class);
Route::resource('categories', CategoryController::class);
