<?php

namespace App\Models;

use App\Enum\ProductQueryStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductQuery extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
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
            'status' => ProductQueryStatus::class,
        ];
    }

    public function productQueryItems(): HasMany
    {
        return $this->hasMany(ProductQueryItem::class);
    }
}
