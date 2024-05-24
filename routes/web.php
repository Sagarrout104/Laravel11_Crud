<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('post/trash', [PostController::class, 'trash'])->name('post.trash');
Route::get('post/{id}/restore', [PostController::class, 'restore'])->name('post.restore');
Route::delete('post/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('post.forcedelete');

Route::resource('post', PostController::class);
