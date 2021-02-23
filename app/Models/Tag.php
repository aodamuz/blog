<?php

namespace App\Models;

class Tag extends Base
{
    /*
    |-------------------------------------------------------------------------
    | Relationships
    |-------------------------------------------------------------------------
    */

    /**
     * Get all of the posts that are assigned this tag.
     */
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
