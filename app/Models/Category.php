<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'image',
        'parent_id',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the children categories of the current category.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
