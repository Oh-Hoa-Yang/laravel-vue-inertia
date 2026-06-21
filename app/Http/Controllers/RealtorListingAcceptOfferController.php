<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{
    // There is a thing called "Single Action Controller"
    public function __invoke(Offer $offer)
    {
        // Accept selected offer
        $offer->update(['accepted_at' => now()]); //Pass the attribute you want to modify inside the array, just make sure that attributes you would like to modify are inside this fillable array (in Model) // => now() set it to now, which would just mean the current date, and this would immediately save the changes.

        $offer->listing->sold_at = now();
        $offer->listing->save();

        // Reject all other offers 
        $offer->listing->offers()->except($offer)
            ->update(['rejected_at' => now()]);

        return redirect()->back()->with('success', "Offer #{$offer->id} accepted, other offers rejected");
    }
}
