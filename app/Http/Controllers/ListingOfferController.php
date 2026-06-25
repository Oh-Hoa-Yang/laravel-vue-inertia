<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use App\Notifications\OfferMade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request) 
    {
        Gate::authorize('view', $listing);
        // since we have the listing fetched, we know that listing has the offers relationship. If you remember about associating new items in 1-to-Many relationship, you can use this relationship save() method. Then pass object, in this case would be new offer object.
        // Hint: You can also call $listing->offers()->make([]) to create a new Offer model
        // Hint: You can also call $listing->offers()->create($request->validate([...])) to create, store and associate the Offer with Listing!
        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:20000000'
                ])
                // We are storing new offer, but offer needs to be made by someone. So, we need to also create an association between a user. Now, you can't store the offer inside the database without associating it with a bidder, so, this field bidder_id is required, this means that we need to do something with the bidder relationship, and also you might remember this from the lectures about relationships that you cna do bidder associate. So, you can create association from the other side because offer belongsTo a bidder and bidder or specifically that the model can have many offers. So, from the other side, this is how you associate that belonging relationship.
                // Now, how can you get the current user, two ways? Either the auth facade user static method ->associate(Auth::user()) 
                // |or|
                // the     easiest way is just to get the user using the $request object that we already have here. ->associate($request->user())
            )->bidder()->associate($request->user())
         );

         $listing->owner->notify(
            new OfferMade($offer)
         );

         return redirect()->back()->with('success', 'Offer was made!');
    }
}
