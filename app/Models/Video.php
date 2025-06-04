<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphTo as MorphToAlias;

class Video extends Model
{
    protected $fillable = [
        'title',
        'url',
        'thumbnail',
        'videoable_id',
        'videoable_type',
    ];

    /**
     * @return MorphTo
     */
    public function videoable(): MorphTo
    {
        return $this->morphTo();
    }
}
