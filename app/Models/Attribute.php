<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        "name",
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute_values');
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    protected function casts(): array
    {
        return [
            'status' => StatusEnum::class,
        ];
    }
}
