<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RealtorListingController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        // dd($request->get('deleted')); //?deleted=true; output: true
        // dd($request->get('deleted') === true);//?deleted=true; output: false
        // dd((bool)$request->get('deleted') === true); //?deleted=true; output: true | ?deleted=false; output: true 
        // it still show 'true', so, to actually convert this value to a Boolean, you would need to call a specific method of the request, which is call boolean
        // dd((bool)$request->boolean('deleted')); // and now, ?deleted=true or =1 or =yes; output:true | ?deleted=false or =0 or =no; output:false
        Gate::authorize('viewAny', Listing::class);
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by','order'])
        ];
        // dd(Auth::user()->listings); // for testing whether it can fetch all the records of that user 
        return inertia(
            'Realtor/Index',
            [
                'filters' => $filters,
                'listings' => Auth::user()
                    ->listings()
                    // ->mostRecent()
                    ->filter($filters)
                    ->paginate(5)
                    ->withQueryString()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Listing::class); // Remember this need to have class, so Laravel can figure out which model policy do you mean
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Listing::class);
        // Checking what we have
        // dd($request->all());
        
        // Way to store it (Single)
        // $listing = new Listing();
        // $listing->beds = $request->beds;
        // $listing->save();
        
        // Instead of setting every single property of the model separately, we can do the below:
        // Listing::create($request->all());



        // Auth::user(); //one way

        // $request->user() //another way
        // this would not only create the new listing, but it would also associate this listing with the current user
        $request->user()->listings()->create(
        // Listing::create(
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
        return redirect()->route('realtor.listing.index')->with('success', 'Listing was created!');
        
        
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

    /**
     * Show the form for editing the specified resource.
     */
    // parameter $listing with Listing model, so Laravel will know to fetch it from the database using the given route parameter
    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);
        return inertia(
            'Realtor/Edit',
            [
                'listing' => $listing
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('update', $listing);
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' =>'required',
                'street_nr' => 'required|min:1|max:1000',
                'price' => 'required|integer|min:1|max:20000000', 
            ])
        );
        return redirect()->route('realtor.listing.index')->with('success', 'Listing was changed!');
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);
        // deleteOrFail() is for the cases where model was already deleted and someone called this action again accidentally for the same model. 
        $listing->deleteOrFail();

        redirect()->back()->with('success', 'Listing was deleted!');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()->with('success', 'Listing was restored');
    }
}
