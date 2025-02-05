<?php

namespace App\Models;

use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        "name",
        "slug",
        "image",
        "description",
        "status",
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
}
