<?php

namespace App\Models;

use App\Models\Listing;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    //Fillable fields are those that you can use in mass assignment, which means you can call either create or store methods on the model, pass the column values in an array, or just fill multiple columns of a model at once. And those would be the amount, accepted_at, rejected_at
    protected $fillable = ['amount', 'accepted_at', 'rejected_at'];

    // Let's define the relationships
    // offers -> Many: 1 Listing
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    // offers -> Many: 1 User
    public function bidder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'bidder_id');
    }

    public function scopeByMe(Builder $query): Builder 
    {
        return $query->where('bidder_id', Auth::user()?->id);
    }
}
