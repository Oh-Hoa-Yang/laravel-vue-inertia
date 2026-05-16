<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
// use Inertia\Inertia;

// Route::get('/', function () {
//     return inertia('Index/index');
// });
//     return Inertia::render('Index/index');
// })->name('home');

// first element is the class name -- IndexController
// Every class in PHP has this static constant which contains the FULLY QUALIFIED CLASS NAME, which means class name, including the namespace.
// Back to the root definition, after a comma, you provide a second element of this array, which is the method name
// etc:   
//Route::get('/',[<class name - controller>::class, '<method name>'])
Route::get('/', [IndexController::class, 'index']);
Route::get('/hello',[IndexController::class, 'show'])
    ->middleware('auth');

Route::resource('listing', ListingController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');
Route::resource('listing', ListingController::class)
    ->except(['create', 'store', 'edit', 'update', 'destroy']);

Route::get('login',[AuthController::class, 'create'])
    ->name('login');
Route::post('login',[AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout',[AuthController::class, 'destroy'])
    ->name('logout');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);


// Only allow the show of 'index' and 'show'; others -> need to check middleware auth (Better Understanding Version)
// Learning Purpose
// Route::resource('listing', ListingController::class)
//     ->only(['index', 'show']);
// Route::resource('listing', ListingController::class)
//     ->except(['index', 'show'])
//     ->middleware('auth');