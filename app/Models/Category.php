<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'image',
        'short_intro',
        'description',
        'meta_keywords',
        'meta_description',
        'status',
    ];

    /**
     * Get the parent category.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the category name with indentation based on nesting level.
     */
    public function getIndentedNameAttribute(): string
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return str_repeat('- ', $depth) . $this->name;
    }

    /**
     * Get the parent category name with indentation.
     */
    public function getIndentedParentNameAttribute(): ?string
    {
        return $this->parent ? $this->parent->indented_name : null;
    }

    /**
     * products
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
