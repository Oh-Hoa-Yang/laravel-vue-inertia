<?php

namespace App\Models;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    use HasFactory;

    protected $fillable = ['filename'];
    protected $appends = ['src'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
        // Notice how I haven't specified the second argument to this belongs to method, which is the column name to use for the foreign key, as Laravel has a mechanism to automatically figure out this column name. 
        // In this example, if you want specify a custom column name, Laravel will just use the relation name 'listing():BelongsTo' underscore id, which will become 'listing_id'
    }

    // getRealSrcAttribute -> real_src
    public function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }
}