<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVairants extends Model
{
    protected $table = 'product_attribute_values';

    public function product(){
        return $this->belongsTo(related: Product::class);
    }

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class);
    }

}
