<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
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
    ->only(['index', 'show']);

Route::resource('listing.offer', ListingOfferController::class)
    ->middleware('auth')
    ->only(['store']);

Route::get('login',[AuthController::class, 'create'])
    ->name('login');
Route::post('login',[AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout',[AuthController::class, 'destroy'])
    ->name('logout');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

Route::prefix('realtor') // in url
    ->name('realtor.')   // in route name
    ->middleware('auth')
    ->group(function () {
        Route::name('listing.restore')
            ->put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->withTrashed();
        Route::resource('listing', RealtorListingController::class)
            ->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
            ->withTrashed(); //Calling withTrashed() with no arguments will allow soft deleted models for show, edit, and update resource routes. 
            // You may specify a subset of these routes by passing an array to the withTrashed method like: Route::resource('photos', PhotoController::class)->withTrashed(['show']);

        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });