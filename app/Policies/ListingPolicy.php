<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    // this before will be run before any ability other method! And for this reason, this user object here as an argument is optional because user might be also unauthenticated.
    public function before(?User $user, $ability) 
    {
        // If you using previous version of PHP(PHP 8.0), then you would have to first check if user itself is not null. 
        // Only then, check if there is admin is true ($user && $user->is_admin) // Otherwise, you would get an error every time the user would not be authenticated.
        // So, from those both ways, the preferred way is to use this null save, the '?' after the variable or the function called as it's the more modern way 
        // ($user->is_admin)
        if ($user?->is_admin /*&& $ability === 'update'*/) {
            return true; 
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Listing $listing): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Listing $listing): bool
    {
        // We need some rules here, it is not everyone can update it
        // we use by_user_id to compare with the user's id
        // this rule means that the only people who can modify a listing are the people who have created the listing
        return $user->id === $listing->by_user_id; /* || $user->is_admin; */
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    // soft delete
    public function restore(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->by_user_id;
    }
}
