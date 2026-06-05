<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use function Laravel\Prompts\form;

class ListingController extends Controller
{
    // Since this ListingController is a resource controller, this means we can use the third way, the simplest way
    // We can use #[Authorize('viewAny', Listing::class)] --> this is for Laravel 13.x
    // For Laravel 12.x, the only way is to use Gate Facades -> index, create, store [Listing::class] | show, edit, update, destroy [$listing]
    // public function __construct()
    // {
    //     $this->authorizeResource(Listing::class, 'listing');
    // }


    /**
     * Display a listing of the resource.
     */
    // #[Authorize('viewAny', Listing::class)]  (remember to import --> this way of doing is for Laravel 13.x)
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Listing::class);
        
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                // 'listings' => Listing::all()
                // With the way of using the local scope, we can use the mostRecent() and filter($filters) anywhere, not only in this specific Controller
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->paginate(10)
                    ->withQueryString()
            ]
        );
    }

    public function show(Listing $listing)
    {
        // you can either try to get the current user and check for this user permissions, or you can use the controller helper method called authorize
        // 'view' is the function name from ListingPolicy.php

        // FIRST example
        // if (Auth::user()->cannot('view', $listing)){
        //     abort(403); // this is our HTTP code for the (action forbidden 禁止行为)
        // }; 
        //Another example is the authorize method from the controller
        //this authorize would do what you have here in the 3 commented lines above -> if (Auth::user()->cannot('view', $listing)){};
        // it would check if the current user is authorized to perform this view operation on this model (Listing in here), if not, it would automatically return 403 code from this controller action (referring to the authorize() method). 
        // $this->authorize('view', $listing); //This is the outdated way of doing
        Gate::authorize('view', $listing); // The modern Laravel 12 replacement for $this->authorize()


        return inertia(
            'Listing/Show',
            [
                'listing' => $listing
            ]
        );
    }

 
}
           