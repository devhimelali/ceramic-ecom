<?php

namespace App\Models;

use App\Enum\StatusEnum;
use App\Helpers\ImageUploadHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'image',
        'short_description',
        'description',
        'price',
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
     * The images that belong to this product.
     *
     * @return HasMany<ProductImage>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }


    // public function attributes()
    // {
    //     return $this->belongsToMany(Attribute::class, 'product_attribute_values')
    //                 ->withPivot('attribute_value_id');
    // }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_values')
                    ->withPivot('attribute_value_id');
    }
    

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id');
    }
    // public function attributeValues()
    // {
    //     return $this->belongsToMany(AttributeValue::class, 'product_attribute_values', 'product_id', 'attribute_value_id');
    // }


    public function productQueryItems()
    {
        return $this->belongsToMany(ProductQueryItem::class, 'product_query_item_variation')
                    ->withPivot('attribute_id', 'attribute_value_id')
                    ->withTimestamps();
    }
}
