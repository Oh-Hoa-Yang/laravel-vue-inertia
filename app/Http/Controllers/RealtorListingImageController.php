<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            // we can submit multiple file 
            foreach ($request->file('images') as $file) {
            $path = $file->store('images', 'public'); // store it to images folder in public disk -> refer to filesystemns.php 


            // Next step, to store the database model
            $listing->images()->save(new ListingImage([
                'filename' => $path
            ]));
            }
        }
        return redirect()->back()->with('success', 'Images uploaded!');
    }
}
