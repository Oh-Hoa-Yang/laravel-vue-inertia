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

    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);
        // deleteOrFail() is for the cases where model was already deleted and someone called this action again accidentally for the same model. 
        $listing->deleteOrFail();

        redirect()->back()->with('success', 'Listing was deleted!');
    }
}
