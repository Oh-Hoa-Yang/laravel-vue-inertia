<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RealtorListingController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Listing::class);
        // dd(Auth::user()->listings); // for testing whether it can fetch all the records of that user 
        return inertia(
            'Realtor/Index',
            ['listings' => Auth::user()->listings]
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
