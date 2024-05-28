<?php

use App\Events\UserRegister;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::middleware('auth')->group(function () {

    Route::get('post/trash', [PostController::class, 'trash'])->name('post.trash');
    Route::get('post/{id}/restore', [PostController::class, 'restore'])->name('post.restore');
    Route::delete('post/{id}/forcedelete', [PostController::class, 'forceDelete'])->name('post.forcedelete');

    Route::resource('post', PostController::class);
});

//testing event listener
Route::get('event-send', function () {
    $email = 'lara123@gmail.com';
    event(new UserRegister($email));
    dd("send mail");
});


//test localization
//en,hi
Route::get('greeting/{lang}', function ($lang) {
    App::setLocale($lang);
    return view('greeting');
})->name('greet');
