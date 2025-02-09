<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductQueryItem extends Model
{
    protected $fillable = [
        'product_query_id',
        'product_id',
    ];


    public function productQuery(): BelongsTo
    {
        return $this->belongsTo(ProductQuery::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
