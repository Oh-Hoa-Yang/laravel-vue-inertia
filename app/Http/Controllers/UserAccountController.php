<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function create() {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request) {
        // We use make() method -> doesn't store a model immediately in the table, so we need to have $user->save(); ELSE; just use create() method without the $user->save();
        $user = User::make($request->validate([ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed' // If you use 'confirmed' validator, you've got one field called 'password', but then a lot of us would expect another data filled send called password_confirmation
        ]));
        $user->save();

        Auth::login($user);

        return redirect()->route('listing.index')->with('success', 'Account created!');
    }
}
