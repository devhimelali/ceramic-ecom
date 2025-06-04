<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Review extends Model
{
    protected $fillable = [
        'product_id',
        'rating',
        'comment',
        'headline',
        'name',
        'email',
        'is_approved'
    ];

    /**
     * Get the product that this review belongs to.
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get all the images for the review.
     *
     * @return MorphMany
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all the videos for the review.
     *
     * @return MorphMany
     */
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'videoable');
    }
}
