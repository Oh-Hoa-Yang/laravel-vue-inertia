<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only(['index']);

Route::put('notifications/{notification}/seen', NotificationSeenController::class)
    ->middleware('auth')->name('notification.seen');

Route::get('login',[AuthController::class, 'create'])
    ->name('login');
Route::post('login',[AuthController::class, 'store'])
    ->name('login.store');
Route::delete('logout',[AuthController::class, 'destroy'])
    ->name('logout');

// You are not really forced to use controllers in Laravel, I think they work best with bigger applications. But you can actually implement every route directly inside this web.php file. And we'll begin with this way and then we might eventually move all those routes to a controller. 
Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})
    ->middleware('auth')
    ->name('verification.notice'); // the reason for this name is that the Laravel mechanism, this verified middleware that stops user from visiting pages when they are not verified, will just redirect to that specific route 'verification.notice'. That's why it needs this specific name

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('listing.index')
        ->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::resource('user-account', UserAccountController::class)
    ->only(['create', 'store']);

Route::prefix('realtor') // in url
    ->name('realtor.')   // in route name
    ->middleware(['auth', 'verified'])
    ->group(function () {
        Route::name('listing.restore')
            ->put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
            ->withTrashed();
        Route::resource('listing', RealtorListingController::class)
            // ->only(['index', 'destroy', 'edit', 'update', 'create', 'store'])
            ->withTrashed(); //Calling withTrashed() with no arguments will allow soft deleted models for show, edit, and update resource routes. 
            // You may specify a subset of these routes by passing an array to the withTrashed method like: Route::resource('photos', PhotoController::class)->withTrashed(['show']);

        // Modify something use PUT or PATCH
        Route::name('offer.accept')
            ->put('offer/{offer}/accept', RealtorListingAcceptOfferController::class);

        Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });