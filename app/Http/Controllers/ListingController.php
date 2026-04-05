<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return inertia(
            'Listing/Index',
            [
                'listings' => Listing::all()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

     // You can do it this way
    // public function show(string $id)
    // {
    //     return inertia(
    //         'Listing/Show',
    //         [
    //             'listing' => Listing::find($id)
    //         ]
    //     );
    // }
    // Or, it's enough that you type hint this argument with the listing model, we can even call that $listing because this would no longer be an ID. 
    // Laravel will instead fetch the model by the given ID from the route parameter and it will be immediately available in this show() method, so you don't have to call find() anymore.
    public function show(Listing $listing)
    {
        return inertia(
            'Listing/Show',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
