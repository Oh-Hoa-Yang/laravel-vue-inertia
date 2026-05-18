<?php

namespace App\Http\Controllers;

// use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    public function index() {
        // dd(Listing::all());
        // dd(Auth::user()); //can use to check all about the authenticated user
        // dd(Auth::check()); // use to check whether the user is authenticated user or not

        dd(
            Hash::make('password'),
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro911C/.og/at2.uheWG/igi',
            Hash::check('password', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro911C/.og/at2.uheWG/igi')
        );

        return inertia(
            'Index/Index',
            [
                'message' => 'Hello from Laravel'
            ]
        );
    }
    public function show() {
        return inertia('Index/Show');
    }
}
