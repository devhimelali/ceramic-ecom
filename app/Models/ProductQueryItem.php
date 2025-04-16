<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQueryItem extends Model
{
    protected $fillable = [
        'product_query_id',
        'product_id',
        'quantity',
        'variation_name'
    ];


    public function productQuery()
    {
        return $this->belongsTo(ProductQuery::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Product::class, 'product_query_item_variation')
            ->withPivot('attribute_id', 'attribute_value_id')
            ->withTimestamps();
    }
}
