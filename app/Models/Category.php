<?php

namespace App\Models;

use App\Traits\HasSlug;

class Category extends Base
{
    use HasSlug;

    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    /**
     * Get all of the posts that are assigned this category.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
