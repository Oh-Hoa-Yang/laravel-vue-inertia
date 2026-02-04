<?php

use Illuminate\Support\Facades\Route;
// use Inertia\Inertia;

Route::get('/', function () {
    return inertia('Index/index');
});
//     return Inertia::render('Index/index');
// })->name('home');
