<?php

namespace App\Models;

use App\Models\User;
// use Illuminate\Database\Eloquent\Attributes\Scope; //use for new version 12.x Laravel
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['beds', 'baths', 'area', 'city', 'code', 'street', 'street_nr', 'price'];

    public function owner(): BelongsTo{
        return $this->belongsTo(
            User::class,
            'by_user_id'
        );
    }

    // From the tutorial
    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }
    
    // Based on the Laravel docs 12.x
    // BOTH WORKS BUT WHEN I USE THE NEW WAY OF DOING - ListingController.php - the place we use mostRecent(), error shows 'Not enough arguments. Expected 1. Found 0. 
    // #[Scope]
    // protected function mostRecent(Builder $query): void
    // {
    //      $query->orderByDesc('created_at');
    // }
}
