<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);
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
            $path = $file->store('images', 'public'); // store it to images folder in public disk -> refer to filesystems.php 


            // Next step, to store the database model
            $listing->images()->save(new ListingImage([
                'filename' => $path
            ]));
            }
        }
        return redirect()->back()->with('success', 'Images uploaded!');
    }

    public function destroy($listing, ListingImage $image) 
    {
        // to access disk, use Storage facade
        // Storage disk has a static disk method which allows you to access either a specific disk or a default disk. -> Check filesystems.php
        // In filesystems, default is 
        Storage::disk('public')->delete($image->filename);
        // delete the model
        $image->delete();

        return redirect()->back()->with('success', 'Image was deleted!');
    }
}
