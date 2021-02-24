<?php

namespace App\Traits;

use Cviebrock\EloquentSluggable\Sluggable;

class HasSlug
{
    use Sluggable;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
