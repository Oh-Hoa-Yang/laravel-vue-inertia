<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

use function Laravel\Prompts\form;

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
        return inertia('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Checking what we have
        // dd($request->all());

        // Way to store it (Single)
        // $listing = new Listing();
        // $listing->beds = $request->beds;
        // $listing->save();

        // Instead of setting every single property of the model separately, we can do the below:
        // Listing::create($request->all());
        Listing::create(
            $request->validate([
            // [
            // this '...' operator, it works essentially the same as the array merge function. 
            // so, it allows you to merge two arrays together
            // ...$request->all(),
            //define some validation constraints
            // ...$request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' =>'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000', //cannot use 20_000_000, errors will be 500!, 'The given value "20_000_000" does not represent a valid number.
            ])
            // how it works? This final array~>create([]), will contain all elements from the first array, and if the second array happens to have some data with the same keys as the first array, those original values from request all would be replaced. So, this lets you create an intersection of two arrays. 
        // ]
        );
        // we can use flash messages, with the use of '->with'
        return redirect()->route('listing.index')->with('success', 'Listing was created!');
        
        
        // Now, mind that storing the user submitted data like that without any validation or sanitization is a bad idea

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
