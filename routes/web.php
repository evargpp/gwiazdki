<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CuisineController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect()->route('restaurants.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// TYLKO ZALOGOWANI – CRUD
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
    Route::get('/restaurants/{restaurant}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
    Route::post('/restaurants/{restaurant}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// WSZYSCY
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');
require __DIR__ . '/auth.php';


Route::controller(CuisineController::class)->group(function () {
    Route::get('/cuisines', 'index')->name('cuisines.index');

    Route::middleware('auth')->group(function () {
        Route::get('/cuisines/create', 'create')->name('cuisines.create');
        Route::post('/cuisines', 'store')->name('cuisines.store');
        Route::get('/cuisines/{cuisine}/edit', 'edit')->name('cuisines.edit');
        Route::put('/cuisines/{cuisine}', 'update')->name('cuisines.update');
        Route::delete('/cuisines/{cuisine}', 'destroy')->name('cuisines.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('/restaurants/{restaurant}/reviews',
        [ReviewController::class, 'store']
    )->name('reviews.store');
});
