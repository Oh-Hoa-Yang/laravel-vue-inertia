<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends Controller
{
    public function create() {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request) {
        // We use make() method -> doesn't store a model immediately in the table, so we need to have $user->save(); ELSE; just use create() method without the $user->save();
        $user = User::create($request->validate([ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed' // If you use 'confirmed' validator, you've got one field called 'password', but then a lot of us would expect another data filled send called password_confirmation
        ]));
        // $user->password = Hash::make($user->password); 
        // Now, we don't have to call Hash::make() as we already do it in the model (User.php) 
        // $user->password = $user->passsword //since you see both are the same -> 1 = 1 ; which is the same, this means that probably we don't need this at all. 
        // Also means that the password attribute can now be just safely set automatically using mass assignment.
        // As a reminder, mass assignment is when you use make or create methods to set the column values.

        // Since we don't do any extra thing over here, so, we dont need this here, and so, we also don't need to use make method, instead we use create method
        // $user->save();

        Auth::login($user);
        event(new Registered($user)); // This is the event that is triggered when a user is registered.

        return redirect()->route('listing.index')->with('success', 'Account created!');
    }
}
