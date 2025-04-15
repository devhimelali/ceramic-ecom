<?php

namespace App\Models;

use App\Enum\StatusEnum;
use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
        ];
    }


    /**
     * The category that this product belongs to.
     *
     * @return BelongsTo<Category, static>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The brand that this product belongs to.
     *
     * @return BelongsTo<Brand, static>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }


    /**
     * Get all the image for the product.
     *
     * @return MorphMany<Image>
     */
    public function images(): MorphMany
    {
        // Define a polymorphic one-to-many relationship.
        return $this->morphMany(Image::class, 'imageable');
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(Attribute::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }


    public function productQueryItems()
    {
        return $this->belongsToMany(ProductQueryItem::class, 'product_query_item_variation')
            ->withPivot('attribute_id', 'attribute_value_id')
            ->withTimestamps();
    }
}
