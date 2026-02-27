<?php

use App\Http\Controllers\IndexController;
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
Route::get('/hello',[IndexController::class, 'show']);