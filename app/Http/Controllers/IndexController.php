<?php

namespace App\Http\Controllers;

// use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index() {
        // dd(Listing::all());
        // dd(Auth::user()); //can use to check all about the authenticated user
        // dd(Auth::check()); // use to check whether the user is authenticated user or not

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
