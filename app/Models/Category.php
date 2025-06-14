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
        'front_show',
        'is_featured',
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

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
}
